@extends('layouts.dashboard')

@section('title', 'Settings')

@section('page-title', 'Settings')

@section('page-content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">There were some errors with your submission</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
        @csrf
        
        <!-- Tenant Profile Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Tenant Profile</h3>
                <p class="text-sm text-gray-500 mt-1">Update your business information and contact details.</p>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Business Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $tenant->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $tenant->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Domain</label>
                        <input type="text" id="domain" value="{{ $tenant->domain }}" disabled
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                        <p class="text-xs text-gray-500 mt-1">Domain cannot be changed</p>
                    </div>
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $tenant->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Currency Settings Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Currency Settings</h3>
                <p class="text-sm text-gray-500 mt-1">Set your preferred currency for all transactions and reports.</p>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                        <select id="currency" name="currency" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency['code'] }}" 
                                        {{ old('currency', $tenant->currency) == $currency['code'] ? 'selected' : '' }}>
                                    {{ $currency['code'] }} - {{ $currency['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="currency_symbol" class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                        <input type="text" id="currency_symbol" name="currency_symbol" 
                               value="{{ old('currency_symbol', $tenant->currency_symbol) }}" required maxlength="5"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Symbol used to display currency (e.g., $, €, £)</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Currency Preview</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Sample: <span id="currency-preview">{{ $tenant->currency_symbol ?? '$' }}1,234.56</span></p>
                                <p>This will be used throughout the application for all monetary values.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tax Settings Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Tax Settings</h3>
                <p class="text-sm text-gray-500 mt-1">Configure tax settings for your POS system and sales.</p>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" id="tax_enabled" name="tax_enabled" value="1" 
                           {{ old('tax_enabled', $tenant->tax_enabled) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="tax_enabled" class="ml-2 block text-sm text-gray-900">
                        Enable Tax Calculation
                    </label>
                    <p class="text-xs text-gray-500 ml-2">Enable tax calculation for all sales</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                        <input type="number" id="tax_rate" name="tax_rate" 
                               value="{{ old('tax_rate', $tenant->tax_rate) }}" 
                               min="0" max="100" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Enter the tax rate as a percentage (e.g., 8.5 for 8.5%)</p>
                    </div>
                    
                    <div>
                        <label for="tax_name" class="block text-sm font-medium text-gray-700 mb-2">Tax Name</label>
                        <input type="text" id="tax_name" name="tax_name" 
                               value="{{ old('tax_name', $tenant->tax_name) }}" maxlength="50"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Custom tax name (e.g., VAT, GST, Sales Tax)</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Pricing Method</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="tax_exclusive" name="tax_inclusive" value="0" 
                                   {{ old('tax_inclusive', $tenant->tax_inclusive) == false ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="tax_exclusive" class="ml-2 block text-sm text-gray-900">
                                Tax Exclusive (Add tax to displayed prices)
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="tax_inclusive" name="tax_inclusive" value="1" 
                                   {{ old('tax_inclusive', $tenant->tax_inclusive) == true ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="tax_inclusive" class="ml-2 block text-sm text-gray-900">
                                Tax Inclusive (Prices include tax)
                            </label>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Choose how tax is applied to product prices</p>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Tax Preview</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                @if($tenant->tax_enabled && $tenant->tax_rate > 0)
                                    <p>Sample: Product price {{ $tenant->currency_symbol }}100.00 + {{ $tenant->tax_name }} ({{ $tenant->tax_rate }}%) = {{ $tenant->currency_symbol }}{{ number_format(100 + ($tenant->tax_rate * 100 / 100), 2) }}</p>
                                @else
                                    <p>Tax is currently disabled. Enable tax calculation to see preview.</p>
                                @endif
                                <p>This will be applied to all sales in your POS system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Settings Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Theme Settings</h3>
                <p class="text-sm text-gray-500 mt-1">Customize the appearance of your SmartPoint interface.</p>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label for="theme" class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                    <select id="theme" name="theme" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="light" {{ old('theme', $tenant->theme) == 'light' ? 'selected' : '' }}>Light Theme</option>
                        <option value="dark" {{ old('theme', $tenant->theme) == 'dark' ? 'selected' : '' }}>Dark Theme</option>
                        <option value="auto" {{ old('theme', $tenant->theme) == 'auto' ? 'selected' : '' }}>Auto (Follow System)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Choose your preferred theme appearance</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                        <select id="timezone" name="timezone" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @php
                                $timezones = [
                                    'UTC' => 'UTC',
                                    'America/New_York' => 'Eastern Time',
                                    'America/Chicago' => 'Central Time',
                                    'America/Denver' => 'Mountain Time',
                                    'America/Los_Angeles' => 'Pacific Time',
                                    'Europe/London' => 'London',
                                    'Europe/Paris' => 'Paris',
                                    'Europe/Berlin' => 'Berlin',
                                    'Asia/Tokyo' => 'Tokyo',
                                    'Asia/Shanghai' => 'Shanghai',
                                    'Asia/Kolkata' => 'India',
                                    'Australia/Sydney' => 'Sydney',
                                    'Pacific/Auckland' => 'Auckland',
                                ];
                            @endphp
                            @foreach($timezones as $value => $label)
                                <option value="{{ $value }}" {{ old('timezone', $tenant->timezone) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="date_format" class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                        <select id="date_format" name="date_format" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Y-m-d" {{ old('date_format', $tenant->date_format) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            <option value="m/d/Y" {{ old('date_format', $tenant->date_format) == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                            <option value="d/m/Y" {{ old('date_format', $tenant->date_format) == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                            <option value="M d, Y" {{ old('date_format', $tenant->date_format) == 'M d, Y' ? 'selected' : '' }}>Jan 01, 2024</option>
                            <option value="d M Y" {{ old('date_format', $tenant->date_format) == 'd M Y' ? 'selected' : '' }}>01 Jan 2024</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="time_format" class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                        <select id="time_format" name="time_format" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="24" {{ old('time_format', $tenant->time_format) == '24' ? 'selected' : '' }}>24-hour (14:30)</option>
                            <option value="12" {{ old('time_format', $tenant->time_format) == '12' ? 'selected' : '' }}>12-hour (2:30 PM)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Subscription Information</h3>
                <p class="text-sm text-gray-500 mt-1">Your current subscription details and plan information.</p>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Plan</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $tenant->subscription_plan ?? 'FREE' }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $tenant->subscription_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($tenant->subscription_status ?? 'inactive') }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Trial Status</label>
                        <div class="flex items-center">
                            @if($tenant->trial_ends_at && $tenant->trial_ends_at->isFuture())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Trial Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    No Trial
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($tenant->trial_ends_at && $tenant->trial_ends_at->isFuture())
                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Trial Period</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Your trial ends on {{ $tenant->trial_ends_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Currency preview update
    const currencySelect = document.getElementById('currency');
    const currencySymbolInput = document.getElementById('currency_symbol');
    const currencyPreview = document.getElementById('currency-preview');
    
    function updateCurrencyPreview() {
        const symbol = currencySymbolInput.value || '$';
        currencyPreview.textContent = symbol + '1,234.56';
    }
    
    currencySymbolInput.addEventListener('input', updateCurrencyPreview);
    updateCurrencyPreview();
    
    // Auto-update currency symbol when currency changes
    currencySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const currencyCode = this.value;
        
        // Find the corresponding currency in the currencies array
        const currencies = @json($currencies);
        const selectedCurrency = currencies.find(c => c.code === currencyCode);
        
        if (selectedCurrency) {
            currencySymbolInput.value = selectedCurrency.symbol;
            updateCurrencyPreview();
        }
    });
});
</script>
@endsection 