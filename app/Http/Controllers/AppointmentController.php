<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Appointment::class);

        // Use query scopes to filter appointments based on user role
        $query = Appointment::with('clinician')
            ->orderByDate('asc');

        // Clinicians only see their own appointments
        if (Auth::user()->isClinician()) {
            $query->forClinician(Auth::id());
        }
        // Admins see all appointments

        $appointments = $query->paginate(15);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Appointment::class);

        // Get all clinicians for the dropdown
        $clinicians = User::where('role', 'clinician')->get();

        return view('appointments.create', compact('clinicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $this->authorize('create', Appointment::class);

        // If user is clinician, automatically set them as the clinician
        $clinicianId = Auth::user()->isClinician() 
            ? Auth::id() 
            : $request->clinician_id;

        Appointment::create([
            'patient_name' => $request->patient_name,
            'clinic_location' => $request->clinic_location,
            'clinician_id' => $clinicianId,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);

        $appointment->load('clinician');
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): View
    {
        $this->authorize('update', $appointment);

        // Get all clinicians for the dropdown
        $clinicians = User::where('role', 'clinician')->get();

        return view('appointments.edit', compact('appointment', 'clinicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $this->authorize('update', $appointment);

        // If user is clinician, ensure they can't change the clinician_id
        $clinicianId = Auth::user()->isClinician() 
            ? $appointment->clinician_id 
            : $request->clinician_id;

        $appointment->update([
            'patient_name' => $request->patient_name,
            'clinic_location' => $request->clinic_location,
            'clinician_id' => $clinicianId,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}
