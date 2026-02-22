<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactInquiry::with('equipment')->latest('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inquiries = $query->paginate(20)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(ContactInquiry $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }

        $inquiry->load('equipment.category');

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, ContactInquiry $inquiry)
    {
        $request->validate(['status' => 'required|in:new,read,replied']);
        $inquiry->update(['status' => $request->status]);

        return back()->with('success', 'Status zapytania został zmieniony.');
    }
}
