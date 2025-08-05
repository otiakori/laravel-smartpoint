<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InvoiceManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedStatus = 'all';
    public $selectedPaymentStatus = 'all';
    public $dateFilter = 'all';
    public $deleteInvoiceId = null;
    public $showDeleteModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedStatus' => ['except' => 'all'],
        'selectedPaymentStatus' => ['except' => 'all'],
        'dateFilter' => ['except' => 'all'],
    ];

    protected $listeners = [
        'invoiceDeleted' => '$refresh',
        'invoiceStatusUpdated' => '$refresh',
    ];

    public function mount()
    {
        $this->search = request('search', '');
        $this->selectedStatus = request('status', 'all');
        $this->selectedPaymentStatus = request('payment_status', 'all');
        $this->dateFilter = request('date_filter', 'all');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatedSelectedPaymentStatus()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function filterByStatus($status)
    {
        $this->selectedStatus = $status;
        $this->resetPage();
    }

    public function filterByPaymentStatus($status)
    {
        $this->selectedPaymentStatus = $status;
        $this->resetPage();
    }

    public function filterByDate($filter)
    {
        $this->dateFilter = $filter;
        $this->resetPage();
    }

    public function deleteInvoice($invoiceId)
    {
        $this->deleteInvoiceId = $invoiceId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if ($this->deleteInvoiceId) {
            $invoice = Invoice::where('tenant_id', Auth::user()->tenant_id)
                ->find($this->deleteInvoiceId);
            
            if ($invoice) {
                $invoice->delete();
                $this->dispatch('invoiceDeleted');
                session()->flash('success', 'Invoice deleted successfully!');
            }
        }
        
        $this->showDeleteModal = false;
        $this->deleteInvoiceId = null;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteInvoiceId = null;
    }

    public function getInvoicesProperty()
    {
        $query = Invoice::where('tenant_id', Auth::user()->tenant_id)
            ->with(['customer', 'user'])
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function ($customerQuery) {
                      $customerQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if ($this->selectedStatus !== 'all') {
            $query->where('invoice_status', $this->selectedStatus);
        }

        // Apply payment status filter
        if ($this->selectedPaymentStatus !== 'all') {
            $query->where('payment_status', $this->selectedPaymentStatus);
        }

        // Apply date filter
        switch ($this->dateFilter) {
            case 'today':
                $query->whereDate('invoice_date', today());
                break;
            case 'this_week':
                $query->whereBetween('invoice_date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('invoice_date', now()->month)
                      ->whereYear('invoice_date', now()->year);
                break;
            case 'overdue':
                $query->overdue();
                break;
            case 'due_today':
                $query->dueToday();
                break;
            case 'due_this_week':
                $query->dueThisWeek();
                break;
        }

        return $query->paginate(15);
    }

    public function getStatsProperty()
    {
        $tenantId = Auth::user()->tenant_id;
        
        $totalInvoices = Invoice::where('tenant_id', $tenantId)->count();
        $draftInvoices = Invoice::where('tenant_id', $tenantId)->byStatus('draft')->count();
        $sentInvoices = Invoice::where('tenant_id', $tenantId)->byStatus('sent')->count();
        $paidInvoices = Invoice::where('tenant_id', $tenantId)->byStatus('paid')->count();
        $overdueInvoices = Invoice::where('tenant_id', $tenantId)->overdue()->count();
        
        $totalAmount = Invoice::where('tenant_id', $tenantId)->sum('total_amount');
        $paidAmount = Invoice::where('tenant_id', $tenantId)->byStatus('paid')->sum('total_amount');
        $pendingAmount = Invoice::where('tenant_id', $tenantId)
            ->whereIn('payment_status', ['pending', 'partial'])
            ->sum('total_amount');

        return [
            'total_invoices' => $totalInvoices,
            'draft_invoices' => $draftInvoices,
            'sent_invoices' => $sentInvoices,
            'paid_invoices' => $paidInvoices,
            'overdue_invoices' => $overdueInvoices,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'pending_amount' => $pendingAmount,
        ];
    }

    public function render()
    {
        return view('livewire.invoice-management', [
            'invoices' => $this->invoices,
            'stats' => $this->stats,
        ]);
    }
} 