<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query();

        if ($request->has('animal_type')) {
            $query->where('animal_type', $request->animal_type);
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'animal_type' => 'required|string|in:domestic,exotic,farm,wild',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer',
            'owner_id' => 'required|exists:owners,id',
        ]);

        $pet = Pet::create($data);

        return response()->json($pet, 201);
    }

    public function show(string $id)
    {
        return Pet::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $pet = Pet::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'animal_type' => 'sometimes|required|string|in:domestic,exotic,farm,wild',
            'breed' => 'nullable|string|max:255',
            'age' => 'sometimes|required|integer',
            'owner_id' => 'sometimes|required|exists:owners,id',
        ]);

        $pet->update($data);

        return response()->json($pet, 200);
    }

    public function destroy(string $id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return response()->json(['message' => 'Pet deleted'], 200);
    }
}
