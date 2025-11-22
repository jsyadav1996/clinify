<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Product::with(['category', 'subcategory', 'user'])
                ->select('products.*');

            // Filter by user role: Admin sees all, Clinician sees only their own
            if (Auth::user()->isClinician()) {
                $query->where('products.user_id', Auth::id());
            }

            // Apply custom filters
            if ($request->has('category_id') && $request->category_id != '') {
                $query->where('products.category_id', $request->category_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('products.status', $request->status);
            }

            return DataTables::of($query)
                ->addColumn('category_name', function ($product) {
                    return $product->category->name ?? '-';
                })
                ->addColumn('subcategory_name', function ($product) {
                    return $product->subcategory->name ?? '-';
                })
                ->addColumn('user_name', function ($product) {
                    return $product->user->name ?? '-';
                })
                ->addColumn('status_badge', function ($product) {
                    $badge = $product->status === 'active' 
                        ? '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>';
                    return $badge;
                })
                ->addColumn('price_formatted', function ($product) {
                    return '$' . number_format($product->price, 2);
                })
                ->addColumn('actions', function ($product) {
                    $editUrl = route('products.edit', $product->id);
                    $showUrl = route('products.show', $product->id);
                    $deleteUrl = route('products.destroy', $product->id);
                    
                    $buttons = '<div class="flex space-x-2">';
                    $buttons .= '<a href="' . $showUrl . '" style="background-color: #2563eb; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: background-color 0.15s ease-in-out;" onmouseover="this.style.backgroundColor=\'#1d4ed8\'" onmouseout="this.style.backgroundColor=\'#2563eb\'">View</a>';
                    $buttons .= '<a href="' . $editUrl . '" style="background-color: #16a34a; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: background-color 0.15s ease-in-out;" onmouseover="this.style.backgroundColor=\'#15803d\'" onmouseout="this.style.backgroundColor=\'#16a34a\'">Edit</a>';
                    $buttons .= '<form method="POST" action="' . $deleteUrl . '" class="inline" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">';
                    $buttons .= csrf_field();
                    $buttons .= method_field('DELETE');
                    $buttons .= '<button type="submit" style="background-color: #dc2626; color: #ffffff; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; border: none; cursor: pointer; transition: background-color 0.15s ease-in-out;" onmouseover="this.style.backgroundColor=\'#b91c1c\'" onmouseout="this.style.backgroundColor=\'#dc2626\'">Delete</button>';
                    $buttons .= '</form>';
                    $buttons .= '</div>';
                    
                    return $buttons;
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('subcategory_name', function ($query, $keyword) {
                    $query->whereHas('subcategory', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $query->where('products.status', $keyword);
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }

        $categories = Category::where('is_active', true)->get();
        return view('products.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);
        
        $categories = Category::where('is_active', true)->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        $product->load(['category', 'subcategory', 'user']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $categories = Category::where('is_active', true)->get();
        $subcategories = $product->category->activeSubcategories ?? collect();
        
        return view('products.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Get subcategories for a given category (AJAX endpoint).
     */
    public function getSubcategories(Request $request): JsonResponse
    {
        $categoryId = $request->get('category_id');
        
        $subcategories = \App\Models\Subcategory::where('category_id', $categoryId)
            ->where('is_active', true)
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}
