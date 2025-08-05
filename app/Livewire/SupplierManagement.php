<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SupplierManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedStatus = '';
    public $deleteSupplierId = null;
    public $showDeleteModal = false;
    public $showAddSupplierModal = false;
    public $showSupplierDetailsModal = false;
    public $selectedSupplier = null;

    // Supplier form properties
    public $supplierName = '';
    public $supplierContactPerson = '';
    public $supplierEmail = '';
    public $supplierPhone = '';
    public $supplierAddress = '';
    public $supplierCity = '';
    public $supplierState = '';
    public $supplierPostalCode = '';
    public $supplierCountry = '';
    public $supplierTaxId = '';
    public $supplierPaymentTerms = '';
    public $supplierCreditLimit = 0;
    public $supplierStatus = 'active';
    public $supplierRating = 0;
    public $supplierNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
    ];

    protected $listeners = [
        'supplierDeleted' => '$refresh',
        'supplierAdded' => '$refresh',
    ];

    public function mount()
    {
        // Initialize with query parameters if they exist
        $this->search = request('search', '');
        $this->selectedStatus = request('status', '');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }

    public function filterByStatus($status)
    {
        $this->selectedStatus = $status;
        $this->resetPage();
    }

    public function searchSuppliers($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function deleteSupplier($supplierId)
    {
        $this->deleteSupplierId = $supplierId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if ($this->deleteSupplierId) {
            $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
                ->find($this->deleteSupplierId);
            
            if ($supplier) {
                // Check if supplier has any purchase orders
                if ($supplier->purchaseOrders()->count() > 0) {
                    session()->flash('error', 'Cannot delete supplier with existing purchase orders.');
                } else {
                    $supplier->delete();
                    $this->dispatch('supplierDeleted');
                    session()->flash('success', 'Supplier deleted successfully!');
                }
            }
        }
        
        $this->showDeleteModal = false;
        $this->deleteSupplierId = null;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteSupplierId = null;
    }

    public function openAddSupplierModal()
    {
        $this->showAddSupplierModal = true;
    }

    public function closeAddSupplierModal()
    {
        $this->showAddSupplierModal = false;
        $this->resetSupplierForm();
    }

    public function resetSupplierForm()
    {
        $this->supplierName = '';
        $this->supplierContactPerson = '';
        $this->supplierEmail = '';
        $this->supplierPhone = '';
        $this->supplierAddress = '';
        $this->supplierCity = '';
        $this->supplierState = '';
        $this->supplierPostalCode = '';
        $this->supplierCountry = '';
        $this->supplierTaxId = '';
        $this->supplierPaymentTerms = '';
        $this->supplierCreditLimit = 0;
        $this->supplierStatus = 'active';
        $this->supplierRating = 0;
        $this->supplierNotes = '';
    }

    public function addSupplier()
    {
        $this->validate([
            'supplierName' => 'required|string|max:255',
            'supplierContactPerson' => 'nullable|string|max:255',
            'supplierEmail' => 'nullable|email|max:255',
            'supplierPhone' => 'nullable|string|max:20',
            'supplierAddress' => 'nullable|string',
            'supplierCity' => 'nullable|string|max:100',
            'supplierState' => 'nullable|string|max:100',
            'supplierPostalCode' => 'nullable|string|max:20',
            'supplierCountry' => 'nullable|string|max:100',
            'supplierTaxId' => 'nullable|string|max:100',
            'supplierPaymentTerms' => 'nullable|string|max:255',
            'supplierCreditLimit' => 'nullable|numeric|min:0',
            'supplierStatus' => 'required|in:active,inactive',
            'supplierRating' => 'nullable|integer|min:0|max:5',
            'supplierNotes' => 'nullable|string',
        ]);

        Supplier::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $this->supplierName,
            'contact_person' => $this->supplierContactPerson,
            'email' => $this->supplierEmail,
            'phone' => $this->supplierPhone,
            'address' => $this->supplierAddress,
            'city' => $this->supplierCity,
            'state' => $this->supplierState,
            'postal_code' => $this->supplierPostalCode,
            'country' => $this->supplierCountry,
            'tax_id' => $this->supplierTaxId,
            'payment_terms' => $this->supplierPaymentTerms,
            'credit_limit' => $this->supplierCreditLimit ?? 0,
            'current_balance' => 0,
            'status' => $this->supplierStatus,
            'rating' => $this->supplierRating ?? 0,
            'notes' => $this->supplierNotes,
        ]);

        $this->dispatch('supplierAdded');
        $this->closeAddSupplierModal();
        session()->flash('success', 'Supplier created successfully!');
    }

    public function showSupplierDetails($supplierId)
    {
        $this->selectedSupplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->with(['purchaseOrders.items.product', 'payments'])
            ->find($supplierId);
        $this->showSupplierDetailsModal = true;
    }

    public function closeSupplierDetailsModal()
    {
        $this->showSupplierDetailsModal = false;
        $this->selectedSupplier = null;
    }

    public function getSuppliersProperty()
    {
        $query = Supplier::where('tenant_id', Auth::user()->tenant_id);

        // Filter by search term
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('contact_person', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        // Filter by status
        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        return $query->with(['purchaseOrders', 'payments'])
                    ->orderBy('name')
                    ->paginate(10);
    }

    public function getStatsProperty()
    {
        $suppliers = Supplier::where('tenant_id', Auth::user()->tenant_id);
        
        return [
            'total_suppliers' => $suppliers->count(),
            'active_suppliers' => $suppliers->where('status', 'active')->count(),
            'total_credit_limit' => $suppliers->sum('credit_limit'),
            'total_outstanding_balance' => $suppliers->sum('current_balance'),
        ];
    }

    public function render()
    {
        return view('livewire.supplier-management', [
            'suppliers' => $this->suppliers,
            'stats' => $this->stats,
        ]);
    }
}
