<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        return Owner::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:owners,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $owner = Owner::create($validated);
        return response()->json($owner, 201);
    }

    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        return response()->json($owner);
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:owners,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $owner->update($validated);
        return response()->json($owner);
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();

        return response()->json(['message' => 'Owner deleted']);
    }
}
