<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Patient Name -->
                        <div>
                            <x-input-label for="patient_name" :value="__('Patient Name')" />
                            <x-text-input id="patient_name" name="patient_name" type="text" class="mt-1 block w-full" :value="old('patient_name', $appointment->patient_name)" required />
                            <x-input-error :messages="$errors->get('patient_name')" class="mt-2" />
                        </div>

                        <!-- Clinic Location -->
                        <div>
                            <x-input-label for="clinic_location" :value="__('Clinic Location')" />
                            <x-text-input id="clinic_location" name="clinic_location" type="text" class="mt-1 block w-full" :value="old('clinic_location', $appointment->clinic_location)" required />
                            <x-input-error :messages="$errors->get('clinic_location')" class="mt-2" />
                        </div>

                        <!-- Clinician -->
                        <div>
                            <x-input-label for="clinician_id" :value="__('Clinician')" />
                            @if(auth()->user()->isClinician())
                                <x-text-input id="clinician_id" type="text" class="mt-1 block w-full bg-gray-100" value="{{ $appointment->clinician->name ?? auth()->user()->name }}" disabled />
                                <input type="hidden" name="clinician_id" value="{{ $appointment->clinician_id }}">
                                <p class="mt-1 text-sm text-gray-500">You cannot change the clinician assignment.</p>
                            @else
                                <select id="clinician_id" name="clinician_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Clinician</option>
                                    @foreach($clinicians as $clinician)
                                        <option value="{{ $clinician->id }}" {{ old('clinician_id', $appointment->clinician_id) == $clinician->id ? 'selected' : '' }}>
                                            {{ $clinician->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <x-input-error :messages="$errors->get('clinician_id')" class="mt-2" />
                        </div>

                        <!-- Appointment Date -->
                        <div>
                            <x-input-label for="appointment_date" :value="__('Appointment Date & Time')" />
                            <x-text-input id="appointment_date" name="appointment_date" type="datetime-local" class="mt-1 block w-full" :value="old('appointment_date', $appointment->appointment_date->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="booked" {{ old('status', $appointment->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $appointment->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button type="submit">Update Appointment</x-primary-button>
                            <a href="{{ route('appointments.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

