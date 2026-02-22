<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('equipment')->ordered()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = null;

        return view('admin.categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = Category::create($data);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategoria została dodana.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $category->update($data);

        if ($request->hasFile('image')) {
            $category->clearMediaCollection('image');
            $category->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategoria została zaktualizowana.');
    }

    public function destroy(Category $category)
    {
        if ($category->equipment()->count() > 0) {
            return back()->withErrors(['error' => 'Nie można usunąć kategorii, która zawiera sprzęt. Najpierw usuń lub przenieś sprzęt.']);
        }

        $category->clearMediaCollection('image');
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategoria została usunięta.');
    }
}
