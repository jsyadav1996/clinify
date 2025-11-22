<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointments') }}
            </h2>
            <a href="{{ route('appointments.create') }}" style="background-color: #3b82f6; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 700; display: inline-flex; align-items: center; text-decoration: none;">
                <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Appointment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm bg-white">
                        <table class="min-w-full divide-y divide-gray-200 appointments-table" id="appointments-table">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Patient Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Clinic Location</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Clinician</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Appointment Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($appointments as $appointment)
                                    <tr class="appointment-row">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $appointment->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">{{ $appointment->patient_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->clinic_location }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appointment->clinician->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($appointment->status === 'booked')
                                                <span class="px-3 py-1.5 text-xs font-bold text-blue-800 bg-blue-100 rounded-full inline-block">Booked</span>
                                            @elseif($appointment->status === 'completed')
                                                <span class="px-3 py-1.5 text-xs font-bold text-green-800 bg-green-100 rounded-full inline-block">Completed</span>
                                            @else
                                                <span class="px-3 py-1.5 text-xs font-bold text-red-800 bg-red-100 rounded-full inline-block">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('appointments.show', $appointment->id) }}" style="background-color: #2563eb; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: all 0.2s ease-in-out;" onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.15)'" onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">View</a>
                                                <a href="{{ route('appointments.edit', $appointment->id) }}" style="background-color: #16a34a; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: all 0.2s ease-in-out;" onmouseover="this.style.backgroundColor='#15803d'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.15)'" onmouseout="this.style.backgroundColor='#16a34a'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">Edit</a>
                                                <form method="POST" action="{{ route('appointments.destroy', $appointment->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background-color: #dc2626; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; border: none; cursor: pointer; transition: all 0.2s ease-in-out;" onmouseover="this.style.backgroundColor='#b91c1c'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.15)'" onmouseout="this.style.backgroundColor='#dc2626'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-gray-500 font-semibold text-base">No appointments found.</p>
                                                <p class="text-gray-400 text-sm mt-1">Create your first appointment to get started.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($appointments->hasPages())
                        <div class="mt-6">
                            {{ $appointments->links() }}
                        </div>
                    @endif
                </div>
            </div>

    @push('scripts')
    <style>
        /* Enhanced Appointments Table Container */
        #appointments-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        /* Enhanced Table Header */
        #appointments-table thead {
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
        }

        #appointments-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
        }

        /* Enhanced Table Rows */
        #appointments-table tbody tr.appointment-row {
            transition: all 0.2s ease-in-out;
            background-color: #ffffff;
        }

        #appointments-table tbody tr.appointment-row:hover {
            background-color: #f9fafb;
            transform: scale(1.001);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        #appointments-table tbody tr.appointment-row:nth-child(even) {
            background-color: #fafafa;
        }

        #appointments-table tbody tr.appointment-row:nth-child(even):hover {
            background-color: #f3f4f6;
        }

        /* Enhanced Table Cells */
        #appointments-table tbody td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        #appointments-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Patient Name Styling */
        #appointments-table tbody td:nth-child(2) {
            font-weight: 700;
            color: #111827;
            font-size: 0.9375rem;
        }

        /* Appointment Date Styling */
        #appointments-table tbody td:nth-child(5) {
            font-weight: 600;
            color: #374151;
        }

        /* Enhanced Status Badges */
        #appointments-table .px-3.py-1\.5 {
            font-weight: 700;
            letter-spacing: 0.025em;
            display: inline-block;
            padding: 0.5rem 0.875rem;
            border-radius: 9999px;
            text-transform: uppercase;
            font-size: 0.6875rem;
        }

        /* Enhanced Action Buttons */
        #appointments-table .flex.space-x-2 a,
        #appointments-table .flex.space-x-2 button {
            transition: all 0.2s ease-in-out;
            font-size: 0.875rem;
            font-weight: 600;
            min-width: 70px;
            text-align: center;
        }

        #appointments-table .flex.space-x-2 a:hover,
        #appointments-table .flex.space-x-2 button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Enhanced Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            padding: 1rem 0;
        }

        .pagination a,
        .pagination span {
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            text-decoration: none;
            color: #374151;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
        }

        .pagination a:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination .active span {
            background: linear-gradient(to bottom, #3b82f6, #2563eb);
            color: white;
            border-color: #2563eb;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }

        .pagination .active span:hover {
            background: linear-gradient(to bottom, #2563eb, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.4);
        }

        .pagination .disabled span {
            opacity: 0.4;
            cursor: not-allowed;
            background-color: #f9fafb;
        }

        /* Empty State Enhancement */
        #appointments-table tbody tr td[colspan] {
            padding: 3rem 1.5rem;
        }
    </style>
    @endpush
        </div>
    </div>
</x-app-layout>

