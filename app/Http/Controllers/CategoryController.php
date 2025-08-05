<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->with(['parent', 'products'])
            ->withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Category::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        // Check if the request is from the products page modal
        if ($request->header('X-Requested-With') === 'XMLHttpRequest' || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!'
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        // Ensure user can only edit categories from their tenant
        if ($category->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->where('id', '!=', $category->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        // Ensure user can only update categories from their tenant
        if ($category->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Ensure user can only delete categories from their tenant
        if ($category->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has products. Please move or delete the products first.');
        }

        // Check if category has subcategories
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has subcategories. Please delete the subcategories first.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
} 