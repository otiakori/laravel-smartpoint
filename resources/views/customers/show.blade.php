@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                ← Back to Customers
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Customer Details</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Information -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $customer->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Phone</label>
                            <p class="text-gray-900">{{ $customer->phone }}</p>
                        </div>

                        @if($customer->email)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900">{{ $customer->email }}</p>
                            </div>
                        @endif

                        @if($customer->address)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Address</label>
                                <p class="text-gray-900">{{ $customer->address }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('customers.edit', $customer) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-center">
                                Edit Customer
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Credit Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Credit Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500">Credit Limit</label>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($customer->credit_limit, 2) }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500">Current Balance</label>
                            <p class="text-2xl font-bold 
                                {{ $customer->credit_balance == 0 ? 'text-green-600' : 
                                   ($customer->credit_balance <= $customer->credit_limit ? 'text-yellow-600' : 'text-red-600') }}">
                                ${{ number_format($customer->credit_balance, 2) }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500">Available Credit</label>
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format(max(0, $customer->credit_limit - $customer->credit_balance), 2) }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500">Credit Utilization</label>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $customer->credit_limit > 0 ? number_format(($customer->credit_balance / $customer->credit_limit) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales History -->
        <div class="mt-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Sales History</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customer->sales as $sale)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $sale->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Regular Sale
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($sale->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No regular sales found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Installment Sales History -->
        <div class="mt-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Installment Sales History</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contract #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customer->installmentSales as $installmentSale)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $installmentSale->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $installmentSale->contract_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($installmentSale->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($installmentSale->paid_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($installmentSale->total_amount - $installmentSale->paid_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $installmentSale->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($installmentSale->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($installmentSale->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No installment sales found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 