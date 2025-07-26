<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->with('category')
            ->orderBy('name')
            ->paginate(12);

        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Product::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'status' => 'active',
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        // Ensure user can only edit products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure user can only update products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Ensure user can only delete products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
} 