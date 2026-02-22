<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::with('media')->ordered()->get();
        return view('admin.portfolio.index', compact('items'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'images.*' => 'image|max:4096',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $item = PortfolioItem::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $item->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.portfolio.edit', $item)
            ->with('success', 'Realizacja została dodana.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        $portfolio->load('media');
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'images.*' => 'image|max:4096',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $portfolio->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $portfolio->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.portfolio.edit', $portfolio)
            ->with('success', 'Realizacja została zaktualizowana.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        $portfolio->clearMediaCollection('images');
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Realizacja została usunięta.');
    }

    public function deleteMedia(PortfolioItem $portfolio, int $mediaId)
    {
        $media = $portfolio->media()->findOrFail($mediaId);
        $media->delete();

        return response()->json(['success' => true]);
    }
}
