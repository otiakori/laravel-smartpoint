<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CustomerManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedStatus = '';
    public $deleteCustomerId = null;
    public $showDeleteModal = false;
    public $showAddCustomerModal = false;
    public $showCustomerDetailsModal = false;
    public $selectedCustomer = null;

    // Customer form properties
    public $customerName = '';
    public $customerEmail = '';
    public $customerPhone = '';
    public $customerAddress = '';
    public $customerCity = '';
    public $customerState = '';
    public $customerPostalCode = '';
    public $customerCountry = '';
    public $customerCreditLimit = 0;
    public $customerStatus = 'active';
    public $customerNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
    ];

    protected $listeners = [
        'customerDeleted' => '$refresh',
        'customerAdded' => '$refresh',
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



    public function searchCustomers($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    public function deleteCustomer($customerId)
    {
        $this->deleteCustomerId = $customerId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if ($this->deleteCustomerId) {
            $customer = Customer::where('tenant_id', Auth::user()->tenant_id)
                ->find($this->deleteCustomerId);
            
            if ($customer) {
                $customer->delete();
                $this->dispatch('customerDeleted');
                session()->flash('success', 'Customer deleted successfully!');
            }
        }
        
        $this->showDeleteModal = false;
        $this->deleteCustomerId = null;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteCustomerId = null;
    }

    public function openAddCustomerModal()
    {
        $this->showAddCustomerModal = true;
    }

    public function closeAddCustomerModal()
    {
        $this->showAddCustomerModal = false;
        $this->resetCustomerForm();
    }

    public function resetCustomerForm()
    {
        $this->customerName = '';
        $this->customerEmail = '';
        $this->customerPhone = '';
        $this->customerAddress = '';
        $this->customerCity = '';
        $this->customerState = '';
        $this->customerPostalCode = '';
        $this->customerCountry = '';
        $this->customerCreditLimit = 0;
        $this->customerStatus = 'active';
        $this->customerNotes = '';
    }

    public function addCustomer()
    {
        $this->validate([
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'nullable|email|max:255',
            'customerPhone' => 'required|string|max:20',
            'customerAddress' => 'nullable|string',
            'customerCity' => 'nullable|string|max:100',
            'customerState' => 'nullable|string|max:100',
            'customerPostalCode' => 'nullable|string|max:20',
            'customerCountry' => 'nullable|string|max:100',
            'customerCreditLimit' => 'nullable|numeric|min:0',
            'customerStatus' => 'required|in:active,inactive',
            'customerNotes' => 'nullable|string',
        ]);

        Customer::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $this->customerName,
            'email' => $this->customerEmail,
            'phone' => $this->customerPhone,
            'address' => $this->customerAddress,
            'city' => $this->customerCity,
            'state' => $this->customerState,
            'postal_code' => $this->customerPostalCode,
            'country' => $this->customerCountry,
            'credit_limit' => $this->customerCreditLimit,
            'current_balance' => 0,
            'status' => $this->customerStatus,
            'notes' => $this->customerNotes,
        ]);

        $this->dispatch('customerAdded');
        $this->closeAddCustomerModal();
        session()->flash('success', 'Customer created successfully!');
    }

    public function showCustomerDetails($customerId)
    {
        $this->selectedCustomer = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->with(['sales', 'installmentSales', 'creditPayments'])
            ->find($customerId);
        $this->showCustomerDetailsModal = true;
    }

    public function closeCustomerDetailsModal()
    {
        $this->showCustomerDetailsModal = false;
        $this->selectedCustomer = null;
    }

    public function getCustomersProperty()
    {
        $query = Customer::where('tenant_id', Auth::user()->tenant_id);

        // Filter by search term
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%");
            });
        }

        // Filter by status
        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }



        return $query->orderBy('name')->paginate(10);
    }

    public function getStatsProperty()
    {
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id);
        
        return [
            'total_customers' => $customers->count(),
            'active_customers' => $customers->where('status', 'active')->count(),
            'total_credit_limit' => $customers->sum('credit_limit'),
            'total_outstanding_balance' => $customers->sum('current_balance'),
        ];
    }

    public function render()
    {
        return view('livewire.customer-management', [
            'customers' => $this->customers,
            'stats' => $this->stats,
        ]);
    }
}
