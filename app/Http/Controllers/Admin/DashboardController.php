<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\PortfolioItem;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'available' => Equipment::where('status', 'available')->count(),
            'rented' => Equipment::where('status', 'rented')->count(),
            'hidden' => Equipment::where('status', 'hidden')->count(),
            'total_equipment' => Equipment::count(),
            'categories' => Category::count(),
            'new_inquiries' => ContactInquiry::where('status', 'new')->count(),
            'total_inquiries' => ContactInquiry::count(),
            'inquiries_this_month' => ContactInquiry::whereMonth('created_at', now()->month)->count(),
            'faqs' => Faq::count(),
            'portfolio' => PortfolioItem::count(),
        ];

        // Popular equipment (most inquired about)
        $popularEquipment = Equipment::withCount(['inquiries' => function($q) {
            $q->whereMonth('created_at', '>=', now()->subMonths(3));
        }])->orderBy('inquiries_count', 'desc')->limit(5)->get();

        $recentEquipment = Equipment::with('category')->latest()->limit(5)->get();
        $recentInquiries = ContactInquiry::with('equipment')->latest('created_at')->limit(5)->get();

        // Inquiries last 7 days for chart
        $inquiriesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $inquiriesChart[] = [
                'date' => $date->format('d.m'),
                'count' => ContactInquiry::whereDate('created_at', $date)->count()
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentEquipment', 'recentInquiries', 'popularEquipment', 'inquiriesChart'));
    }
}
