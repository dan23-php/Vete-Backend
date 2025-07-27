<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Treatment;

class TreatmentController extends Controller
{
    // List all treatments
    public function index()
    {
        return Treatment::with(['appointment', 'pet', 'vet'])->get();
    }

    // Store a new treatment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:vets,id',
            'date' => 'required|date',
            'diagnosis' => 'required|string',
            'medication' => 'nullable|string',
            'outcome' => 'nullable|string',
        ]);

        $treatment = Treatment::create($validated);

        return response()->json($treatment, 201);
    }

    // Show a single treatment
    public function show($id)
    {
        return Treatment::with(['appointment', 'pet', 'vet'])->findOrFail($id);
    }

    // Update a treatment
    public function update(Request $request, $id)
    {
        $treatment = Treatment::findOrFail($id);

        $treatment->update($request->only([
            'date',
            'diagnosis',
            'medication',
            'outcome'
        ]));

        return response()->json($treatment);
    }

    // Delete a treatment
    public function destroy($id)
    {
        $treatment = Treatment::findOrFail($id);
        $treatment->delete();

        return response()->json(['message' => 'Treatment deleted']);
    }
}
