<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with(['category', 'media'])->ordered();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $equipment = $query->paginate(20)->withQueryString();
        $categories = Category::ordered()->get();

        return view('admin.equipment.index', compact('equipment', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $equipment = null;

        return view('admin.equipment.create', compact('categories', 'equipment'));
    }

    public function store(Request $request)
    {
        $data = $this->validateEquipment($request);
        $data['is_price_negotiable'] = $request->boolean('is_price_negotiable');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['service_available'] = $request->boolean('service_available');

        $equipment = Equipment::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $equipment->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.equipment.edit', $equipment)
            ->with('success', 'Sprzęt został dodany.');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::active()->ordered()->get();
        $equipment->load('media');

        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $data = $this->validateEquipment($request, $equipment->id);
        $data['is_price_negotiable'] = $request->boolean('is_price_negotiable');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['service_available'] = $request->boolean('service_available');

        if ($data['status'] !== 'rented') {
            $data['rented_until'] = null;
        }

        $equipment->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $equipment->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.equipment.edit', $equipment)
            ->with('success', 'Sprzęt został zaktualizowany.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->clearMediaCollection('images');
        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Sprzęt został usunięty.');
    }

    public function toggleVisibility(Equipment $equipment)
    {
        $equipment->update([
            'status' => $equipment->status === 'hidden' ? 'available' : 'hidden',
        ]);

        return back()->with('success', 'Widoczność sprzętu została zmieniona.');
    }

    public function markRented(Request $request, Equipment $equipment)
    {
        $request->validate([
            'rented_until' => 'required|date|after:today',
        ]);

        $equipment->update([
            'status' => 'rented',
            'rented_until' => $request->rented_until,
        ]);

        return back()->with('success', 'Sprzęt oznaczony jako wynajęty.');
    }

    public function markAvailable(Equipment $equipment)
    {
        $equipment->update([
            'status' => 'available',
            'rented_until' => null,
        ]);

        return back()->with('success', 'Sprzęt oznaczony jako dostępny.');
    }

    public function uploadMedia(Request $request, Equipment $equipment)
    {
        $request->validate(['image' => 'required|image|max:4096']);

        $media = $equipment->addMediaFromRequest('image')->toMediaCollection('images');

        return response()->json([
            'id' => $media->id,
            'thumb' => $media->getUrl('thumb'),
            'url' => $media->getUrl(),
        ]);
    }

    public function deleteMedia(Equipment $equipment, int $mediaId)
    {
        $media = $equipment->media()->findOrFail($mediaId);
        $media->delete();

        return response()->json(['success' => true]);
    }

    private function validateEquipment(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price_per_day' => 'nullable|numeric|min:0',
            'is_price_negotiable' => 'boolean',
            'status' => 'required|in:available,rented,hidden',
            'rented_until' => 'nullable|date|required_if:status,rented',
            'is_featured' => 'boolean',
            'service_available' => 'boolean',
            'brand' => 'nullable|string|max:100',
            'condition_notes' => 'nullable|string',
            'sort_order' => 'integer|min:0',
        ]);
    }
}
