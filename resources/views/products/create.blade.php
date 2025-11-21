<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="product-form" method="POST" action="{{ route('products.store') }}" class="space-y-6">
                        @csrf

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            <span id="category_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <x-input-label for="subcategory_id" :value="__('Subcategory')" />
                            <select id="subcategory_id" name="subcategory_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required disabled>
                                <option value="">Select Subcategory</option>
                            </select>
                            <x-input-error :messages="$errors->get('subcategory_id')" class="mt-2" />
                            <span id="subcategory_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Product Name -->
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <span id="name_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Price -->
                        <div>
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            <span id="price_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity', 0)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            <span id="quantity_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            <span id="status_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <span id="description_error" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button type="submit">Create Product</x-primary-button>
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const categorySelect = $('#category_id');
            const subcategorySelect = $('#subcategory_id');
            const form = $('#product-form');

            // Load subcategories when category changes
            categorySelect.on('change', function() {
                const categoryId = $(this).val();
                subcategorySelect.html('<option value="">Loading...</option>').prop('disabled', true);

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('products.subcategories') }}",
                        method: 'GET',
                        data: { category_id: categoryId },
                        success: function(data) {
                            subcategorySelect.html('<option value="">Select Subcategory</option>');
                            if (data.length > 0) {
                                data.forEach(function(subcategory) {
                                    subcategorySelect.append(
                                        $('<option></option>')
                                            .attr('value', subcategory.id)
                                            .text(subcategory.name)
                                    );
                                });
                                subcategorySelect.prop('disabled', false);
                            } else {
                                subcategorySelect.html('<option value="">No subcategories available</option>');
                            }
                        },
                        error: function() {
                            subcategorySelect.html('<option value="">Error loading subcategories</option>');
                            showError('subcategory_error', 'Failed to load subcategories. Please try again.');
                        }
                    });
                } else {
                    subcategorySelect.html('<option value="">Select Subcategory</option>').prop('disabled', true);
                }
            });

            // Client-side validation
            function validateForm() {
                let isValid = true;
                clearErrors();

                // Category validation
                if (!categorySelect.val()) {
                    showError('category_error', 'Please select a category.');
                    isValid = false;
                }

                // Subcategory validation
                if (!subcategorySelect.val() || subcategorySelect.prop('disabled')) {
                    showError('subcategory_error', 'Please select a subcategory.');
                    isValid = false;
                }

                // Name validation
                const name = $('#name').val().trim();
                if (!name) {
                    showError('name_error', 'Product name is required.');
                    isValid = false;
                } else if (name.length > 255) {
                    showError('name_error', 'Product name must not exceed 255 characters.');
                    isValid = false;
                }

                // Price validation
                const price = parseFloat($('#price').val());
                if (isNaN(price) || price < 0) {
                    showError('price_error', 'Please enter a valid price (0 or greater).');
                    isValid = false;
                } else if (price > 999999.99) {
                    showError('price_error', 'Price must not exceed 999,999.99.');
                    isValid = false;
                }

                // Quantity validation
                const quantity = parseInt($('#quantity').val());
                if (isNaN(quantity) || quantity < 0) {
                    showError('quantity_error', 'Please enter a valid quantity (0 or greater).');
                    isValid = false;
                }

                // Status validation
                if (!$('#status').val()) {
                    showError('status_error', 'Please select a status.');
                    isValid = false;
                }

                // Description validation
                const description = $('#description').val();
                if (description && description.length > 1000) {
                    showError('description_error', 'Description must not exceed 1000 characters.');
                    isValid = false;
                }

                return isValid;
            }

            function showError(fieldId, message) {
                $('#' + fieldId).text(message).removeClass('hidden');
                $('#' + fieldId.replace('_error', '')).addClass('border-red-500');
            }

            function clearErrors() {
                $('[id$="_error"]').addClass('hidden').text('');
                $('input, select, textarea').removeClass('border-red-500');
            }

            // Real-time validation
            $('#name, #price, #quantity, #description').on('blur', function() {
                validateForm();
            });

            // Form submission
            form.on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
            });

            // Clear errors on input
            $('input, select, textarea').on('input change', function() {
                const fieldName = $(this).attr('id');
                if (fieldName) {
                    $('#' + fieldName + '_error').addClass('hidden');
                    $(this).removeClass('border-red-500');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>

