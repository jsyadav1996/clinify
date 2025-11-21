<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by AppointmentPolicy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_name' => ['required', 'string', 'max:255'],
            'clinic_location' => ['required', 'string', 'max:255'],
            'clinician_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    return $query->where('role', 'clinician');
                }),
            ],
            'appointment_date' => ['required', 'date'],
            'status' => ['required', 'in:booked,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'patient_name.required' => 'Patient name is required.',
            'patient_name.max' => 'Patient name must not exceed 255 characters.',
            'clinic_location.required' => 'Clinic location is required.',
            'clinic_location.max' => 'Clinic location must not exceed 255 characters.',
            'clinician_id.required' => 'Please select a clinician.',
            'clinician_id.exists' => 'The selected clinician is invalid.',
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_date.date' => 'Please enter a valid date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be booked, completed, or cancelled.',
            'notes.max' => 'Notes must not exceed 1000 characters.',
        ];
    }
}
