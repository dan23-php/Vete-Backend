<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalUsers = User::count();
        $totalPets = Pet::count();
        $totalAppointments = Appointment::count();
        $upcomingAppointments = Appointment::where('appointment_date', '>=', Carbon::now())->count();
        $completedTreatments = Treatment::where('status', 'completed')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_pets' => $totalPets,
            'total_appointments' => $totalAppointments,
            'upcoming_appointments' => $upcomingAppointments,
            'completed_treatments' => $completedTreatments,
        ]);
    }
}
