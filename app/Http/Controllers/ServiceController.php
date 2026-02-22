<?php

namespace App\Http\Controllers;

use App\Models\ServicePage;

class ServiceController extends Controller
{
    public function index()
    {
        $servicePage = ServicePage::getContent();

        if (!$servicePage) {
            abort(404);
        }

        return view('services.index', compact('servicePage'));
    }
}
