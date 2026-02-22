<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->withCount('activeEquipment')->get();
        $featured = Equipment::featured()->with(['category', 'media'])->ordered()->limit(8)->get();

        return view('home', compact('categories', 'featured'));
    }
}
