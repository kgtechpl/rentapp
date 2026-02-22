<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->ordered()->withCount('activeEquipment')->with('media')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        abort_if(! $category->is_active, 404);

        $statusFilter = request('status', 'all');

        $query = $category->equipment()->with(['category', 'media'])->public();

        if ($statusFilter === 'available') {
            $query->where('status', 'available');
        } elseif ($statusFilter === 'rented') {
            $query->where('status', 'rented');
        }

        $equipment = $query->ordered()->get();

        return view('categories.show', compact('category', 'equipment', 'statusFilter'));
    }
}
