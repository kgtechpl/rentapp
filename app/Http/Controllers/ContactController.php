<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\NewInquiryMail;
use App\Mail\CustomerConfirmationMail;
use App\Models\ContactInquiry;
use App\Models\Equipment;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function index()
    {
        $equipment = Equipment::public()->with('category')->ordered()->get();

        return view('contact.index', compact('equipment'));
    }

    public function store(ContactRequest $request)
    {
        $key = 'contact_' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withInput()
                ->withErrors(['message' => "Zbyt wiele zapytań. Spróbuj ponownie za {$seconds} sekund."]);
        }

        RateLimiter::hit($key, 3600);

        $inquiry = ContactInquiry::create([
            ...$request->validated(),
            'status' => 'new',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        // Load equipment relation for emails
        $inquiry->load('equipment');

        // Email to admin
        $adminEmail = Setting::get('email');
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new NewInquiryMail($inquiry));
            } catch (\Exception $e) {
                // Mail failed silently – inquiry is still saved
            }
        }

        // Autoresponder email to customer
        if ($inquiry->email) {
            try {
                Mail::to($inquiry->email)->send(new CustomerConfirmationMail($inquiry));
            } catch (\Exception $e) {
                // Mail failed silently
            }
        }

        return redirect()->route('contact.index')
            ->with('success', 'Dziękujemy za wiadomość! Otrzymasz potwierdzenie na email.');
    }
}
