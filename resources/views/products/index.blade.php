<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('products.create') }}" style="background-color: #3b82f6; color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 700; display: inline-flex; align-items: center; text-decoration: none;">
                <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
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
                    <div class="mb-4">
                        <div class="flex flex-row items-end gap-4">
                            <div class="flex-1">
                                <label for="filter_category" class="block text-sm font-medium text-gray-700 mb-1">Filter by Category</label>
                                <select id="filter_category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" style="height: 2.5rem;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="filter_status" class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                                <select id="filter_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" style="height: 2.5rem;">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="flex-shrink-0" style="margin-bottom: 0;">
                                <label class="block text-sm font-medium text-gray-700 mb-1 opacity-0 pointer-events-none">Placeholder</label>
                                <button id="clear_filters" class="bg-gray-500 hover:bg-gray-700 text-white font-bold rounded whitespace-nowrap" style="height: 2.5rem; padding: 0 1rem;">
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table id="products-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Product Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Category</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Subcategory</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Price</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Quantity</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Status</th>
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Owner</th>
                                        @endif
                                    @endauth
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <!-- DataTables will populate this -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Fix DataTables length menu dropdown styling */
        .dataTables_length {
            margin-bottom: 1rem;
        }
        .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        .dataTables_length select {
            padding: 0.5rem 2.5rem 0.5rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: white;
            font-size: 0.875rem;
            font-weight: 500;
            height: 2.5rem;
            min-width: 80px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 12px 12px;
            cursor: pointer;
        }
        .dataTables_length select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 1px #6366f1;
        }
        .dataTables_length select:hover {
            border-color: #9ca3af;
        }

        /* Enhanced Table Styling */
        #products-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        #products-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
        }

        #products-table tbody tr {
            transition: all 0.2s ease-in-out;
        }

        #products-table tbody tr:hover {
            background-color: #f9fafb;
            transform: scale(1.001);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        #products-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        #products-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Enhanced action buttons in table */
        #products-table .flex.space-x-2 a,
        #products-table .flex.space-x-2 button {
            transition: all 0.2s ease-in-out;
            font-size: 0.75rem;
        }

        #products-table .flex.space-x-2 a:hover,
        #products-table .flex.space-x-2 button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        /* Status badge enhancements */
        #products-table .px-2.py-1 {
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        /* Price formatting */
        #products-table tbody td:nth-child(5) {
            font-weight: 600;
            color: #059669;
        }

        /* Quantity formatting */
        #products-table tbody td:nth-child(6) {
            font-weight: 500;
        }

        /* Search box styling */
        .dataTables_filter input {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Pagination styling */
        .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            transition: all 0.2s;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .dataTables_paginate .paginate_button.current:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
    </style>
    <script>
        $(document).ready(function() {
            var table = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products.index') }}",
                    data: function(d) {
                        d.category_id = $('#filter_category').val();
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'subcategory_name', name: 'subcategory_name' },
                    { data: 'price_formatted', name: 'price' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                    @auth
                        @if(auth()->user()->isAdmin())
                            { data: 'user_name', name: 'user_name' },
                        @endif
                    @endauth
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: '<"flex justify-between items-center mb-4"<"flex items-center gap-4"l><"flex items-center gap-4"f>>rt<"flex justify-between items-center mt-4"<"flex items-center"i><"flex items-center"p>>'
            });

            // Filter handlers
            $('#filter_category, #filter_status').on('change', function() {
                table.draw();
            });

            $('#clear_filters').on('click', function() {
                $('#filter_category').val('');
                $('#filter_status').val('');
                table.draw();
            });
        });
    </script>
    @endpush
</x-app-layout>

