<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Total Products - Admin sees all, Clinician sees only their own
        $totalProductsQuery = Product::query();
        if ($user->isClinician()) {
            $totalProductsQuery->where('user_id', $user->id);
        }
        $totalProducts = $totalProductsQuery->count();

        // Total Appointments - Admin sees all, Clinician sees only their own
        $totalAppointmentsQuery = Appointment::query();
        if ($user->isClinician()) {
            $totalAppointmentsQuery->forClinician($user->id);
        }
        $totalAppointments = $totalAppointmentsQuery->count();

        // Upcoming Appointments (Next 7 Days) - Admin sees all, Clinician sees only their own
        $upcomingAppointmentsQuery = Appointment::upcomingDays(7);
        if ($user->isClinician()) {
            $upcomingAppointmentsQuery->forClinician($user->id);
        }
        $upcomingAppointments = $upcomingAppointmentsQuery->count();

        return view('dashboard', compact(
            'user',
            'totalProducts',
            'totalAppointments',
            'upcomingAppointments'
        ));
    }
}
