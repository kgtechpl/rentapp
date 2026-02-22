<?php

namespace App\Http\Controllers;

use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function show(Equipment $equipment)
    {
        abort_if($equipment->status === 'hidden', 404);

        $equipment->load(['category', 'media']);

        return view('equipment.show', compact('equipment'));
    }
}
