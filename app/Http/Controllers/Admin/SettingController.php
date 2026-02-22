<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    private array $keys = [
        'company_name', 'phone', 'email', 'address',
        'whatsapp', 'facebook_url', 'google_maps_embed',
        'hero_title', 'hero_subtitle', 'contact_intro',
    ];

    public function index()
    {
        $settings = Setting::allAsArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings.company_name' => 'required|string|max:100',
            'settings.phone' => 'nullable|string|max:20',
            'settings.email' => 'nullable|email|max:150',
            'settings.address' => 'nullable|string|max:255',
            'settings.whatsapp' => 'nullable|string|max:20',
            'settings.facebook_url' => 'nullable|url|max:255',
            'settings.google_maps_embed' => 'nullable|string',
            'settings.hero_title' => 'nullable|string|max:200',
            'settings.hero_subtitle' => 'nullable|string|max:400',
            'settings.contact_intro' => 'nullable|string|max:400',
        ]);

        foreach ($this->keys as $key) {
            Setting::set($key, $request->input("settings.{$key}", ''));
        }

        return back()->with('success', 'Ustawienia zostały zapisane.');
    }
}
