<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::with('media')->active()->ordered()->get();
        $categories = PortfolioItem::active()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('portfolio.index', compact('items', 'categories'));
    }

    public function show(PortfolioItem $portfolio)
    {
        abort_if(!$portfolio->is_active, 404);

        $portfolio->load('media');

        return view('portfolio.show', compact('portfolio'));
    }
}
