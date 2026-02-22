<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'company_name' => 'WynaJem Sprzętu',
            'phone' => '+48 123 456 789',
            'email' => 'kontakt@wynajem.pl',
            'address' => 'ul. Przykładowa 1, 00-001 Warszawa',
            'whatsapp' => '48123456789',
            'facebook_url' => '',
            'google_maps_embed' => '',
            'hero_title' => 'Wynajem sprzętu budowlanego i ogrodowego',
            'hero_subtitle' => 'Profesjonalny sprzęt na każdą okazję. Zadzwoń i zapytaj o dostępność.',
            'contact_intro' => 'Masz pytania? Skontaktuj się z nami – odpiszemy jak najszybciej.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
