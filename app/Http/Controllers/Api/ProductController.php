<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $query = Product::with(['category', 'subcategory']);

        // Filter by user role: Admin sees all, Clinician sees only their own
        if ($user->isClinician()) {
            $query->where('user_id', $user->id);
        }

        // Apply filters if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();

        return $this->successResponse($products, 'Products retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $product = Product::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $product->load(['category', 'subcategory']);

        return $this->successResponse($product, 'Product created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'subcategory', 'user'])->find($id);

        if (!$product) {
            return $this->notFoundResponse('Product not found');
        }

        // Check authorization
        /** @var User $user */
        $user = Auth::user();
        if ($user->isClinician() && $product->user_id !== $user->id) {
            return $this->unauthorizedResponse('You do not have permission to view this product');
        }

        return $this->successResponse($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->notFoundResponse('Product not found');
        }

        // Check authorization
        /** @var User $user */
        $user = Auth::user();
        if ($user->isClinician() && $product->user_id !== $user->id) {
            return $this->unauthorizedResponse('You do not have permission to update this product');
        }

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $product->load(['category', 'subcategory']);

        return $this->successResponse($product, 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->notFoundResponse('Product not found');
        }

        // Check authorization
        /** @var User $user */
        $user = Auth::user();
        if ($user->isClinician() && $product->user_id !== $user->id) {
            return $this->unauthorizedResponse('You do not have permission to delete this product');
        }

        $product->delete();

        return $this->successResponse(null, 'Product deleted successfully');
    }
}
