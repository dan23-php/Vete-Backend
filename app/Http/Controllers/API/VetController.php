<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vet;

class VetController extends Controller
{
    // Get all vets
    public function index()
    {
        return Vet::all();
    }

    // Create a new vet
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vets,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $vet = Vet::create($data);

        return response()->json($vet, 201);
    }

    // Show a single vet
    public function show($id)
    {
        $vet = Vet::findOrFail($id);
        return response()->json($vet);
    }

    // Update a vet
    public function update(Request $request, $id)
    {
        $vet = Vet::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:vets,email,' . $vet->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $vet->update($data);

        return response()->json($vet);
    }

    // Delete a vet
    public function destroy($id)
    {
        $vet = Vet::findOrFail($id);
        $vet->delete();

        return response()->json(['message' => 'Vet deleted successfully']);
    }
}
