@extends('layouts.dashboard')

@section('page-content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Installment Plans</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Manage customer installment payment plans</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.location.href='{{ route('installment-plans.create') }}'" 
                        class="px-3 sm:px-4 py-2 bg-blue-600 text-white text-sm sm:text-base rounded-lg hover:bg-blue-700 transition-colors">
                    + New Installment Plan
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Active Plans</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['active_plans'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Outstanding</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ formatCurrency($stats['total_outstanding'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Overdue</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['overdue_count'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-purple-100 rounded-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Due Today</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['due_today'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Search by customer name, plan ID..." 
                       class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex space-x-3">
                <select class="px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="overdue">Overdue</option>
                </select>
                <select class="px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Customers</option>
                    @foreach($customers ?? [] as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Installment Plans Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Plan ID</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($installmentPlans ?? [] as $plan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                            #{{ $plan->id }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                    <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-xs sm:text-sm font-medium text-blue-600">
                                            {{ strtoupper(substr($plan->customer->name ?? 'N/A', 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $plan->customer->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $plan->customer->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                            @if($plan->sale && $plan->sale->saleItems)
                                @foreach($plan->sale->saleItems->take(2) as $item)
                                    <div>{{ $item->quantity }}x {{ $item->product->name ?? 'N/A' }}</div>
                                @endforeach
                                @if($plan->sale->saleItems->count() > 2)
                                    <div class="text-gray-500">+{{ $plan->sale->saleItems->count() - 2 }} more</div>
                                @endif
                            @else
                                <span class="text-gray-500">No items</span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1">
                                <p class="text-sm font-medium text-gray-900">{{ formatCurrency($plan->total_amount) }}</p>
                                <p class="text-xs text-gray-500">Total Amount</p>
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1">
                                <p class="text-sm font-medium text-gray-900">{{ formatCurrency($plan->paid_amount) }}</p>
                                <p class="text-xs text-gray-500">Paid</p>
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 sm:w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $plan->progress_percentage }}%"></div>
                                </div>
                                <span class="ml-2 text-xs sm:text-sm text-gray-600">{{ round($plan->progress_percentage) }}%</span>
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            @if($plan->status === 'active')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif($plan->status === 'completed')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Completed
                                </span>
                            @elseif($plan->status === 'overdue')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Overdue
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($plan->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium space-x-1 sm:space-x-2">
                            <button onclick="window.location.href='{{ route('installment-plans.show', $plan->id) }}'" 
                                    class="text-blue-600 hover:text-blue-900 p-1">View</button>
                            <button onclick="window.location.href='{{ route('installment-plans.edit', $plan->id) }}'" 
                                    class="text-green-600 hover:text-green-900 p-1">Edit</button>
                            <button onclick="processPayment({{ $plan->id }})" 
                                    class="text-purple-600 hover:text-purple-900 p-1">Pay</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-3 sm:px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No installment plans found</p>
                                <p class="text-sm">Create your first installment plan to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($installmentPlans) && $installmentPlans->hasPages())
        <div class="bg-white px-4 sm:px-6 py-3 border-t border-gray-200">
            {{ $installmentPlans->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Process Payment</h3>
            <form id="paymentForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Amount</label>
                    <input type="number" id="paymentAmount" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select id="paymentMethod" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="card">Card</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                    <input type="text" id="referenceNumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea id="paymentNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentPlanId = null;

function processPayment(planId) {
    currentPlanId = planId;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentForm').reset();
}

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('amount', document.getElementById('paymentAmount').value);
    formData.append('payment_method', document.getElementById('paymentMethod').value);
    formData.append('reference_number', document.getElementById('referenceNumber').value);
    formData.append('notes', document.getElementById('paymentNotes').value);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch(`/installment-plans/${currentPlanId}/payments`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closePaymentModal();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the payment.');
    });
});
</script>
@endsection 