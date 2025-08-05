@extends('layouts.dashboard')

@section('page-content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Create Installment Plan</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Convert a sale to an installment payment plan</p>
            </div>
            <button onclick="window.location.href='{{ route('installment-plans.index') }}'" 
                    class="px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                ← Back to Plans
            </button>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Sale Selection -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-6 sm:mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Sale</h2>
            
                            <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Sales</label>
                    <input type="text" id="saleSearch" placeholder="Search by customer name, sale number..." 
                           class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                @if($selectedSale)
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-900 mb-2">Pre-selected Sale</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Sale ID:</span>
                            <span class="font-medium text-blue-900">#{{ $selectedSale->id }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Customer:</span>
                            <span class="font-medium text-blue-900">{{ $selectedSale->customer->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Total Amount:</span>
                            <span class="font-medium text-blue-900">{{ formatCurrency($selectedSale->total_amount) }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Date:</span>
                            <span class="font-medium text-blue-900">{{ $selectedSale->sale_date ? $selectedSale->sale_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                    </div>
                    <button type="button" onclick="selectSale({{ $selectedSale->id }}, {{ $selectedSale->total_amount }}, '{{ $selectedSale->customer->name ?? 'N/A' }}', {{ $selectedSale->customer_id ?? 'null' }})" 
                            class="mt-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Use This Sale
                    </button>
                </div>
                @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Sale ID</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sales ?? [] as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                #{{ $sale->id }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-xs sm:text-sm font-medium text-blue-600">
                                                {{ strtoupper(substr($sale->customer->name ?? 'N/A', 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $sale->customer->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $sale->customer->phone ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                @if($sale->saleItems)
                                    @foreach($sale->saleItems->take(2) as $item)
                                        <div>{{ $item->quantity }}x {{ $item->product->name ?? 'N/A' }}</div>
                                    @endforeach
                                    @if($sale->saleItems->count() > 2)
                                        <div class="text-gray-500">+{{ $sale->saleItems->count() - 2 }} more</div>
                                    @endif
                                @else
                                    <span class="text-gray-500">No items</span>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                {{ formatCurrency($sale->total_amount) }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                {{ $sale->sale_date ? $sale->sale_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium">
                                <button onclick="selectSale({{ $sale->id }}, {{ $sale->total_amount }}, '{{ $sale->customer->name ?? 'N/A' }}', {{ $sale->customer_id ?? 'null' }})" 
                                        class="text-blue-600 hover:text-blue-900 p-1">Select</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-3 sm:px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No sales found</p>
                                    <p class="text-sm">Create a sale first to convert it to an installment plan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Installment Plan Form -->
        <div id="installmentForm" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 hidden">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Installment Plan Details</h2>
            
            <form action="{{ route('installment-plans.store') }}" method="POST">
                @csrf
                <input type="hidden" id="saleId" name="sale_id">
                <input type="hidden" id="customerId" name="customer_id">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                        <input type="text" id="customerName" readonly class="w-full px-3 sm:px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <input type="text" id="totalAmount" readonly class="w-full px-3 sm:px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Installments</label>
                        <input type="number" name="installment_count" min="2" max="60" value="6" required
                               class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Frequency</label>
                        <select name="payment_frequency" required
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="monthly" selected>Monthly</option>
                            <option value="quarterly">Quarterly</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" required
                               class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Additional notes about this installment plan..."
                              class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-blue-900 mb-2">Installment Summary</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Installment Amount:</span>
                            <span id="installmentAmount" class="font-medium text-blue-900">$0.00</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Total Interest:</span>
                            <span id="totalInterest" class="font-medium text-blue-900">$0.00</span>
                        </div>
                        <div>
                            <span class="text-blue-700">End Date:</span>
                            <span id="endDate" class="font-medium text-blue-900">-</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="resetForm()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                        Reset
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                        Create Installment Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectSale(saleId, totalAmount, customerName, customerId) {
    document.getElementById('saleId').value = saleId;
    document.getElementById('customerId').value = customerId;
    document.getElementById('customerName').value = customerName;
    document.getElementById('totalAmount').value = '$' + totalAmount.toFixed(2);
    
    document.getElementById('installmentForm').classList.remove('hidden');
    
    // Set default start date to today
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="start_date"]').value = today;
    
    // Calculate installment details
    calculateInstallments();
}

function resetForm() {
    document.getElementById('installmentForm').classList.add('hidden');
    document.getElementById('saleId').value = '';
    document.getElementById('customerName').value = '';
    document.getElementById('totalAmount').value = '';
}

function calculateInstallments() {
    const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace('$', '')) || 0;
    const installmentCount = parseInt(document.querySelector('input[name="installment_count"]').value) || 6;
    const frequency = document.querySelector('select[name="payment_frequency"]').value;
    const startDate = document.querySelector('input[name="start_date"]').value;
    
    const installmentAmount = totalAmount / installmentCount;
    document.getElementById('installmentAmount').textContent = '$' + installmentAmount.toFixed(2);
    document.getElementById('totalInterest').textContent = '$0.00'; // No interest for now
    
    // Calculate end date
    if (startDate) {
        const start = new Date(startDate);
        let endDate = new Date(start);
        
        switch(frequency) {
            case 'weekly':
                endDate.setDate(start.getDate() + (installmentCount - 1) * 7);
                break;
            case 'biweekly':
                endDate.setDate(start.getDate() + (installmentCount - 1) * 14);
                break;
            case 'monthly':
                endDate.setMonth(start.getMonth() + (installmentCount - 1));
                break;
            case 'quarterly':
                endDate.setMonth(start.getMonth() + (installmentCount - 1) * 3);
                break;
        }
        
        document.getElementById('endDate').textContent = endDate.toLocaleDateString();
    }
}

// Add event listeners for real-time calculation
document.querySelector('input[name="installment_count"]').addEventListener('input', calculateInstallments);
document.querySelector('select[name="payment_frequency"]').addEventListener('change', calculateInstallments);
document.querySelector('input[name="start_date"]').addEventListener('change', calculateInstallments);
</script>
@endsection 