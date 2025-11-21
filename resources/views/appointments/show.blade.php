<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('appointments.edit', $appointment->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('appointments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Appointment Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Patient Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->patient_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Clinic Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->clinic_location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Clinician</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->clinician->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Appointment Date & Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($appointment->status === 'booked')
                                            <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Booked</span>
                                        @elseif($appointment->status === 'completed')
                                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Completed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelled</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Additional Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->notes ?: 'No notes provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->created_at->format('M d, Y h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->updated_at->format('M d, Y h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

