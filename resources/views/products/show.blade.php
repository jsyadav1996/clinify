<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Product Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Subcategory</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->subcategory->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($product->price, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->quantity }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($product->status === 'active')
                                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
                                        @endif
                                    </dd>
                                </div>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Owner</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $product->user->name ?? 'N/A' }}</dd>
                                        </div>
                                    @endif
                                @endauth
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Additional Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->description ?: 'No description provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y h:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

