<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->withCount('activeEquipment')->get();
        $featured = Equipment::featured()->with(['categories', 'media'])->ordered()->limit(8)->get();
        $recent = Equipment::public()->with(['categories', 'media'])->latest()->limit(8)->get();

        return view('home', compact('categories', 'featured', 'recent'));
    }
}
