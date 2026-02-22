<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Equipment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'available' => Equipment::where('status', 'available')->count(),
            'rented' => Equipment::where('status', 'rented')->count(),
            'hidden' => Equipment::where('status', 'hidden')->count(),
            'categories' => Category::count(),
            'new_inquiries' => ContactInquiry::where('status', 'new')->count(),
        ];

        $recentEquipment = Equipment::with('category')
            ->latest()
            ->limit(5)
            ->get();

        $recentInquiries = ContactInquiry::with('equipment')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEquipment', 'recentInquiries'));
    }
}
