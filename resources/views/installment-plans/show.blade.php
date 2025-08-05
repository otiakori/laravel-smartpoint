@extends('layouts.dashboard')

@section('page-content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Installment Plan #{{ $installmentPlan->id }}</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Payment plan for {{ $installmentPlan->customer->name ?? 'N/A' }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.location.href='{{ route('installment-plans.edit', $installmentPlan->id) }}'" 
                        class="px-3 sm:px-4 py-2 text-sm sm:text-base text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Plan
                </button>
                <button onclick="window.location.href='{{ route('installment-plans.index') }}'" 
                        class="px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    ← Back to Plans
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
            <!-- Plan Overview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Plan Overview</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <p class="text-sm text-gray-900">{{ $installmentPlan->customer->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <p class="text-sm text-gray-900">{{ $installmentPlan->customer->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                        <p class="text-lg font-semibold text-gray-900">{{ formatCurrency($installmentPlan->total_amount) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Installment Amount</label>
                        <p class="text-lg font-semibold text-gray-900">{{ formatCurrency($installmentPlan->installment_amount) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Installments</label>
                        <p class="text-sm text-gray-900">{{ $installmentPlan->installment_count }} payments</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Frequency</label>
                        <p class="text-sm text-gray-900">{{ ucfirst($installmentPlan->payment_frequency) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <p class="text-sm text-gray-900">{{ $installmentPlan->start_date ? $installmentPlan->start_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <p class="text-sm text-gray-900">{{ $installmentPlan->end_date ? $installmentPlan->end_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Payment Progress</span>
                        <span>{{ round($installmentPlan->progress_percentage) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $installmentPlan->progress_percentage }}%"></div>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-4">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        @if($installmentPlan->status === 'active')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-2">
                                Active
                            </span>
                        @elseif($installmentPlan->status === 'completed')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 ml-2">
                                Completed
                            </span>
                        @elseif($installmentPlan->status === 'overdue')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ml-2">
                                Overdue
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-2">
                                {{ ucfirst($installmentPlan->status) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Paid:</span>
                        <span class="text-sm text-gray-900 ml-1">{{ formatCurrency($installmentPlan->paid_amount) }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-700">Remaining:</span>
                        <span class="text-sm text-gray-900 ml-1">{{ formatCurrency($installmentPlan->remaining_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Sold -->
            @if($installmentPlan->sale && $installmentPlan->sale->saleItems)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Items Sold</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($installmentPlan->sale->saleItems as $item)
                            <tr>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $item->product->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ formatCurrency($item->unit_price) }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                    {{ formatCurrency($item->total_price) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Payment Schedule -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Payment Schedule</h2>
                    <button onclick="processPayment({{ $installmentPlan->id }})" 
                            class="px-3 sm:px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        + Record Payment
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Paid Date</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($installmentPlan->paymentSchedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                    {{ $schedule->installment_number }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $schedule->due_date ? $schedule->due_date->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                    {{ formatCurrency($schedule->amount) }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    @if($schedule->status === 'paid')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Paid
                                        </span>
                                    @elseif($schedule->status === 'overdue')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Overdue
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $schedule->paid_date ? $schedule->paid_date->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium">
                                    @if($schedule->status !== 'paid')
                                        <button onclick="paySchedule({{ $schedule->id }}, {{ $schedule->amount }})" 
                                                class="text-blue-600 hover:text-blue-900 p-1">Pay</button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-3 sm:px-6 py-8 text-center text-gray-500">
                                    No payment schedules found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sm:space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <button onclick="processPayment({{ $installmentPlan->id }})" 
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Record Payment
                    </button>
                    <button onclick="window.location.href='{{ route('installment-plans.edit', $installmentPlan->id) }}'" 
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                        Edit Plan
                    </button>
                    <button onclick="printPlan()" 
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                        Print Plan
                    </button>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Payments</h3>
                <div class="space-y-3">
                    @forelse($installmentPlan->installmentPayments->take(5) as $payment)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ formatCurrency($payment->amount) }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ ucfirst($payment->payment_method) }}</p>
                            @if($payment->reference_number)
                                <p class="text-xs text-gray-400">{{ $payment->reference_number }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">No payments recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Notes -->
            @if($installmentPlan->notes)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes</h3>
                <p class="text-sm text-gray-700">{{ $installmentPlan->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Record Payment</h3>
            <form id="paymentForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Amount</label>
                    <input type="number" id="paymentAmount" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select id="paymentMethod" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="card">Card</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                    <input type="text" id="referenceNumber" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea id="paymentNotes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePaymentModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentPlanId = {{ $installmentPlan->id }};
let currentScheduleId = null;

function processPayment(planId) {
    currentPlanId = planId;
    currentScheduleId = null;
    document.getElementById('paymentAmount').value = '';
    document.getElementById('paymentModal').classList.remove('hidden');
}

function paySchedule(scheduleId, amount) {
    currentScheduleId = scheduleId;
    document.getElementById('paymentAmount').value = amount;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentForm').reset();
    currentScheduleId = null;
}

function printPlan() {
    window.print();
}

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('amount', document.getElementById('paymentAmount').value);
    formData.append('payment_method', document.getElementById('paymentMethod').value);
    formData.append('reference_number', document.getElementById('referenceNumber').value);
    formData.append('notes', document.getElementById('paymentNotes').value);
    formData.append('_token', '{{ csrf_token() }}');
    
    const url = currentScheduleId 
        ? `/installment-plans/${currentPlanId}/schedule/${currentScheduleId}/pay`
        : `/installment-plans/${currentPlanId}/payments`;
    
    console.log('Submitting payment to:', url);
    console.log('Form data:', Object.fromEntries(formData));
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            closePaymentModal();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error occurred'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the payment: ' + error.message);
    });
});
</script>
@endsection 