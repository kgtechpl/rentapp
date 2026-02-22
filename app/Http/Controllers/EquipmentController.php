<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function show(Equipment $equipment)
    {
        abort_if($equipment->status === 'hidden', 404);

        $equipment->load(['category', 'media']);

        return view('equipment.show', compact('equipment'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Equipment::with('category')
            ->public()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->ordered()
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'brand' => $item->brand,
                    'category' => $item->category->name,
                    'price' => $item->price_display,
                    'status' => $item->status_label,
                    'url' => route('equipment.show', $item),
                    'image' => $item->getFirstMediaUrl('images', 'thumb'),
                ];
            });

        return response()->json($results);
    }
}
