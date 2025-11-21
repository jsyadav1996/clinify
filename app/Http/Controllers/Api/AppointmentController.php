<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $query = Appointment::with('clinician');

        // Filter by user role: Admin sees all, Clinician sees only their own
        if ($user->isClinician()) {
            $query->forClinician($user->id);
        }

        // Apply filters if provided
        if ($request->has('status')) {
            $query->withStatus($request->status);
        }

        if ($request->has('upcoming') && $request->upcoming == 'true') {
            $query->upcoming();
        }

        $appointments = $query->orderByDate('asc')->get();

        return $this->successResponse($appointments, 'Appointments retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        // If user is clinician, automatically set them as the clinician
        $clinicianId = $user->isClinician() 
            ? $user->id 
            : $request->clinician_id;

        $appointment = Appointment::create([
            'patient_name' => $request->patient_name,
            'clinic_location' => $request->clinic_location,
            'clinician_id' => $clinicianId,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        $appointment->load('clinician');

        return $this->successResponse($appointment, 'Appointment created successfully', 201);
    }
}
