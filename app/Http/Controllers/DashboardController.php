<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Treatment;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalUsers = User::count();
        $totalPets = Pet::count();
        $totalAppointments = Appointment::count();

        $upcomingAppointments = Appointment::where('appointment_date', '>=', Carbon::now())
            ->where('appointment_date', '<=', Carbon::now()->addDays(7))
            ->count();

        $completedTreatments = Treatment::where('status', 'completed')->count();

        // Example recent login activity (based on 'updated_at' or custom login timestamp)
        $recentLogins = User::orderBy('updated_at', 'desc')
            ->take(5)
            ->get(['id', 'name', 'email', 'updated_at']);

        return response()->json([
            'total_users' => $totalUsers,
            'total_pets' => $totalPets,
            'total_appointments' => $totalAppointments,
            'upcoming_appointments' => $upcomingAppointments,
            'completed_treatments' => $completedTreatments,
            'recent_logins' => $recentLogins,
        ]);
    }
}
