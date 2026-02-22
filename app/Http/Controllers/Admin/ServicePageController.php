<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePage;
use Illuminate\Http\Request;

class ServicePageController extends Controller
{
    public function index()
    {
        $servicePage = ServicePage::first() ?? new ServicePage([
            'title' => 'Nasze usługi',
            'content' => '',
            'is_active' => true,
        ]);

        return view('admin.service-page.index', compact('servicePage'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $servicePage = ServicePage::first();
        if ($servicePage) {
            $servicePage->update($validated);
        } else {
            ServicePage::create($validated);
        }

        return redirect()->route('admin.service-page.index')
            ->with('success', 'Strona usług została zaktualizowana.');
    }
}
