<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProductManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = 'all';
    public $selectedStockStatus = '';
    public $deleteProductId = null;
    public $showDeleteModal = false;
    public $showAddCategoryModal = false;

    // Category form properties
    public $categoryName = '';
    public $categoryDescription = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => 'all'],
        'selectedStockStatus' => ['except' => ''],
    ];

    protected $listeners = [
        'productDeleted' => '$refresh',
        'categoryAdded' => '$refresh',
    ];

    public function mount()
    {
        // Initialize with query parameters if they exist
        $this->search = request('search', '');
        $this->selectedCategory = request('category', 'all');
        $this->selectedStockStatus = request('stock_status', '');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedSelectedStockStatus()
    {
        $this->resetPage();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function filterByStockStatus($status)
    {
        $this->selectedStockStatus = $status;
        $this->resetPage();
    }

    public function searchProducts($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function deleteProduct($productId)
    {
        $this->deleteProductId = $productId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if ($this->deleteProductId) {
            $product = Product::where('tenant_id', Auth::user()->tenant_id)
                ->find($this->deleteProductId);
            
            if ($product) {
                $product->delete();
                $this->dispatch('productDeleted');
                session()->flash('success', 'Product deleted successfully!');
            }
        }
        
        $this->showDeleteModal = false;
        $this->deleteProductId = null;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteProductId = null;
    }

    public function openAddCategoryModal()
    {
        $this->showAddCategoryModal = true;
    }

    public function closeAddCategoryModal()
    {
        $this->showAddCategoryModal = false;
        $this->categoryName = '';
        $this->categoryDescription = '';
    }

    public function addCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
            'categoryDescription' => 'nullable|string',
        ]);

        Category::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $this->categoryName,
            'description' => $this->categoryDescription,
            'status' => 'active',
        ]);

        $this->dispatch('categoryAdded');
        $this->closeAddCategoryModal();
        session()->flash('success', 'Category created successfully!');
    }

    public function getProductsProperty()
    {
        $query = Product::where('tenant_id', Auth::user()->tenant_id)
            ->with('category');

        // Filter by category
        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        // Filter by search term
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%")
                  ->orWhere('barcode', 'like', "%{$this->search}%");
            });
        }

        // Filter by stock status
        if (!empty($this->selectedStockStatus)) {
            switch ($this->selectedStockStatus) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 10);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '<=', 0);
                    break;
            }
        }

        return $query->orderBy('name')->paginate(5);
    }

    public function getCategoriesProperty()
    {
        $categories = Category::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Add product count for each category
        foreach ($categories as $category) {
            $category->product_count = Product::where('tenant_id', Auth::user()->tenant_id)
                ->where('category_id', $category->id)
                ->count();
        }

        return $categories;
    }

    public function getStatsProperty()
    {
        $products = Product::where('tenant_id', Auth::user()->tenant_id);
        
        return [
            'total_products' => $products->count(),
            'total_categories' => $this->categories->count(),
            'low_stock' => $products->where('stock_quantity', '<=', 10)->count(),
            'total_value' => $products->sum('price'),
        ];
    }

    public function render()
    {
        return view('livewire.product-management', [
            'products' => $this->products,
            'categories' => $this->categories,
            'stats' => $this->stats,
        ]);
    }
}
