<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PosSystem extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $selectedCategory = 'all';
    public $cart = [];
    public $isProcessing = false;
    public $selectedCustomer = '';
    public $paymentMethod = 'card';
    public $showCustomerModal = false;
    public $customers = [];
    public $debugMode = false; // For debugging

    protected $listeners = ['productAdded' => 'addToCart'];

    public function mount()
    {
        $this->loadCustomers();
    }

    public function loadCustomers()
    {
        $this->customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->get();
    }

    public function getProductsProperty()
    {
        $query = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->with('category');

        if ($this->searchQuery) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('barcode', 'like', '%' . $this->searchQuery . '%');
            });
        }

        if ($this->selectedCategory !== 'all') {
            $query->whereHas('category', function($q) {
                $q->where('name', $this->selectedCategory);
            });
        }

        // Only show products with stock > 0
        $query->where('stock_quantity', '>', 0);

        $products = $query->get();
        
        // Debug: Log the query and results
        \Log::info('POS Products Query', [
            'selectedCategory' => $this->selectedCategory,
            'searchQuery' => $this->searchQuery,
            'productsCount' => $products->count(),
            'products' => $products->pluck('name', 'id')->toArray(),
            'categories' => $this->categories->pluck('name')->toArray()
        ]);

        return $products;
    }

    public function getCategoriesProperty()
    {
        return Category::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->get();
    }

    public function addToCart($productId)
    {
        // Debug: Log the attempt to add product
        \Log::info('Attempting to add product to cart', [
            'productId' => $productId,
            'selectedCategory' => $this->selectedCategory,
            'currentProducts' => $this->products->pluck('id')->toArray()
        ]);
        
        $product = Product::find($productId);
        
        if (!$product || $product->tenant_id !== Auth::user()->tenant_id) {
            session()->flash('error', 'Product not found or access denied.');
            \Log::warning('Product not found or access denied', ['productId' => $productId]);
            return;
        }

        // Check if product has stock
        if ($product->stock_quantity <= 0) {
            session()->flash('error', "Cannot add {$product->name} - Out of stock!");
            \Log::warning('Attempted to add out-of-stock product', ['productId' => $productId, 'productName' => $product->name]);
            return;
        }

        $existingItem = collect($this->cart)->firstWhere('id', $productId);
        
        if ($existingItem) {
            // Check if adding one more would exceed stock
            if ($existingItem['quantity'] >= $product->stock_quantity) {
                session()->flash('error', "Cannot add more {$product->name} - Only {$product->stock_quantity} in stock!");
                return;
            }
            
            $this->cart = collect($this->cart)->map(function($item) use ($productId) {
                if ($item['id'] == $productId) {
                    $item['quantity']++;
                }
                return $item;
            })->toArray();
        } else {
            $this->cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'quantity' => 1
            ];
        }
        
        session()->flash('success', "Added {$product->name} to cart!");
        \Log::info('Product added to cart successfully', [
            'productId' => $productId,
            'productName' => $product->name,
            'cartCount' => count($this->cart)
        ]);
    }

    public function updateQuantity($index, $change)
    {
        if (isset($this->cart[$index])) {
            $newQuantity = $this->cart[$index]['quantity'] + $change;
            
            if ($newQuantity >= 1 && $newQuantity <= $this->cart[$index]['stock_quantity']) {
                $this->cart[$index]['quantity'] = $newQuantity;
            }
        }
    }

    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
        }
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->selectedCustomer = '';
    }

    public function selectCategory($categoryName)
    {
        $this->selectedCategory = $categoryName;
        $this->resetPage(); // Reset pagination if using pagination
        
        // Force a re-render of the component
        $this->dispatch('category-changed', category: $categoryName);
        
        // Debug: Log the category change
        \Log::info('Category changed', [
            'newCategory' => $categoryName,
            'productsCount' => $this->products->count()
        ]);
    }

    public function toggleDebug()
    {
        $this->debugMode = !$this->debugMode;
    }

    public function testCategoryFilter($categoryName)
    {
        // Test the category filtering directly
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->whereHas('category', function($q) use ($categoryName) {
                $q->where('name', $categoryName);
            })
            ->where('stock_quantity', '>', 0)
            ->get();
            
        \Log::info('Category filter test', [
            'categoryName' => $categoryName,
            'productsFound' => $products->count(),
            'products' => $products->pluck('name')->toArray()
        ]);
        
        session()->flash('success', "Found {$products->count()} products in category '{$categoryName}'");
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getTaxProperty()
    {
        $tenant = Auth::user()->tenant;
        return $tenant->calculateTax($this->subtotal);
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->tax;
    }

    public function processSale()
    {
        if (empty($this->cart)) {
            return;
        }

        $this->isProcessing = true;

        try {
            // Create the sale
            $sale = Sale::create([
                'tenant_id' => Auth::user()->tenant_id,
                'user_id' => Auth::user()->id,
                'customer_id' => $this->selectedCustomer ?: null,
                'sale_number' => 'SALE-' . time(),
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax,
                'discount_amount' => 0,
                'total_amount' => $this->total,
                'payment_method' => $this->paymentMethod,
                'payment_status' => 'paid',
                'sale_status' => 'completed',
                'sale_date' => now(),
            ]);

            // Create sale items
            $tenant = Auth::user()->tenant;
            foreach ($this->cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $itemTax = $tenant->calculateTax($itemTotal);
                
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $itemTotal,
                    'discount_amount' => 0,
                    'tax_amount' => $itemTax,
                ]);

                // Update product stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            // Clear cart and redirect to receipt
            $this->cart = [];
            $this->selectedCustomer = '';
            $this->isProcessing = false;

            return redirect()->route('pos.receipt', $sale->id)
                ->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            $this->isProcessing = false;
            session()->flash('error', 'Error processing sale: ' . $e->getMessage());
        }
    }

    public function convertToInstallmentPlan()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty.');
            return;
        }

        if (!$this->selectedCustomer) {
            session()->flash('error', 'Please select a customer for installment plan.');
            return;
        }

        $this->isProcessing = true;

        try {
            // Create the sale first
            $sale = Sale::create([
                'tenant_id' => Auth::user()->tenant_id,
                'user_id' => Auth::user()->id,
                'customer_id' => $this->selectedCustomer,
                'sale_number' => 'SALE-' . time(),
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax,
                'discount_amount' => 0,
                'total_amount' => $this->total,
                'payment_method' => 'cash', // Initial payment
                'payment_status' => 'paid',
                'sale_status' => 'completed',
                'sale_date' => now(),
            ]);

            // Create sale items
            $tenant = Auth::user()->tenant;
            foreach ($this->cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $itemTax = $tenant->calculateTax($itemTotal);
                
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $itemTotal,
                    'discount_amount' => 0,
                    'tax_amount' => $itemTax,
                ]);

                // Update product stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            // Clear cart
            $this->cart = [];
            $this->selectedCustomer = '';
            $this->isProcessing = false;

            // Redirect to create installment plan
            return redirect()->route('installment-plans.create', ['sale_id' => $sale->id])
                ->with('success', 'Sale completed! Now create the installment plan.');

        } catch (\Exception $e) {
            $this->isProcessing = false;
            session()->flash('error', 'Error processing sale: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pos-system');
    }
} 