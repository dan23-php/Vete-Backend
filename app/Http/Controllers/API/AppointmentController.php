<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // ✅ List all appointments (for vet)
    public function index()
    {
        $appointments = Appointment::with(['vet', 'pet'])->get();
        return response()->json($appointments);
    }

    // ✅ Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'vet_id' => 'required|exists:vets,id',
            'pet_id' => 'required|exists:pets,id',
            'appointment_date' => 'required|date|after:now',
        ]);

        // Optional: prevent double-booking
        $existing = Appointment::where('vet_id', $request->vet_id)
            ->where('appointment_date', $request->appointment_date)
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Vet already has an appointment at that time.'], 409);
        }

        $appointment = Appointment::create([
            'vet_id' => $request->vet_id,
            'pet_id' => $request->pet_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'scheduled',
        ]);

        return response()->json($appointment, 201);
    }

    // ✅ Show one appointment
    public function show($id)
    {
        $appointment = Appointment::with(['vet', 'pet'])->findOrFail($id);
        return response()->json($appointment);
    }

    // ✅ Update appointment (optional)
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update($request->only([
            'appointment_date',
            'status',
        ]));

        return response()->json($appointment);
    }

    // ✅ Delete appointment
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted.']);
    }

    // ✅ List upcoming appointments (next 7 days)
    public function upcoming()
    {
        $upcoming = Appointment::where('appointment_date', '>=', now())
            ->where('appointment_date', '<=', now()->addDays(7))
            ->with(['vet', 'pet'])
            ->get();

        return response()->json($upcoming);
    }

    // ✅ Mark as completed
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();

        return response()->json(['message' => 'Appointment marked as completed.']);
    }
}
