<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\ServicePage;

class ServiceController extends Controller
{
    public function index()
    {
        $servicePage = ServicePage::getContent();

        if (!$servicePage) {
            abort(404);
        }

        $serviceEquipment = Equipment::public()
            ->where('service_available', true)
            ->with(['categories', 'media'])
            ->ordered()
            ->get();

        return view('services.index', compact('servicePage', 'serviceEquipment'));
    }
}
