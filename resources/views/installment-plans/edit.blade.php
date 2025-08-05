@extends('layouts.dashboard')

@section('page-content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Installment Plan #{{ $installmentPlan->id }}</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Update installment plan details</p>
            </div>
            <button onclick="window.location.href='{{ route('installment-plans.show', $installmentPlan->id) }}'" 
                    class="px-3 sm:px-4 py-2 text-sm sm:text-base text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                ← Back to Plan
            </button>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <form action="{{ route('installment-plans.update', $installmentPlan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                        <input type="text" value="{{ $installmentPlan->customer->name ?? 'N/A' }}" readonly 
                               class="w-full px-3 sm:px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <input type="text" value="{{ formatCurrency($installmentPlan->total_amount) }}" readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" required
                                class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="active" {{ $installmentPlan->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ $installmentPlan->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $installmentPlan->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Installment Amount</label>
                        <input type="text" value="{{ formatCurrency($installmentPlan->installment_amount) }}" readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="4" placeholder="Additional notes about this installment plan..."
                              class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $installmentPlan->notes }}</textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-blue-900 mb-2">Plan Summary</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Installments:</span>
                            <span class="font-medium text-blue-900">{{ $installmentPlan->installment_count }} payments</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Paid Amount:</span>
                            <span class="font-medium text-blue-900">{{ formatCurrency($installmentPlan->paid_amount) }}</span>
                        </div>
                        <div>
                            <span class="text-blue-700">Remaining:</span>
                            <span class="font-medium text-blue-900">{{ formatCurrency($installmentPlan->remaining_amount) }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="window.location.href='{{ route('installment-plans.show', $installmentPlan->id) }}'" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 