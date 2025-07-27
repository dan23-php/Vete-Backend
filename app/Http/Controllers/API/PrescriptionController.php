<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        return Prescription::with('treatment')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'treatment_id' => 'required|exists:treatments,id',
            'medication' => 'required|string',
            'dosage' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        $prescription = Prescription::create($data);

        return response()->json($prescription, 201);
    }

    public function show($id)
    {
        return Prescription::with('treatment')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        $data = $request->validate([
            'medication' => 'sometimes|string',
            'dosage' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        $prescription->update($data);

        return response()->json($prescription);
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return response()->json(['message' => 'Prescription deleted']);
    }
}
