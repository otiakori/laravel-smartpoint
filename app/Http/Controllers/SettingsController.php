<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $tenant = Auth::user()->tenant;
        $currencies = $this->getAvailableCurrencies();
        
        return view('settings.index', compact('tenant', 'currencies'));
    }

    /**
     * Update tenant settings
     */
    public function update(Request $request)
    {
        $tenant = Auth::user()->tenant;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:5',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_enabled' => 'boolean',
            'tax_name' => 'nullable|string|max:50',
            'tax_inclusive' => 'boolean',
            'theme' => 'required|in:light,dark,auto',
            'timezone' => 'required|string|max:50',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|in:12,24',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $tenant->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'currency' => $request->currency,
                'currency_symbol' => $request->currency_symbol,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_enabled' => $request->has('tax_enabled'),
                'tax_name' => $request->tax_name ?? 'Tax',
                'tax_inclusive' => $request->has('tax_inclusive'),
                'theme' => $request->theme,
                'timezone' => $request->timezone,
                'date_format' => $request->date_format,
                'time_format' => $request->time_format,
            ]);

            return back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update settings: ' . $e->getMessage()]);
        }
    }

    /**
     * Get available currencies
     */
    private function getAvailableCurrencies()
    {
        return [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$'],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$'],
            ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF'],
            ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥'],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹'],
            ['code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$'],
            ['code' => 'MXN', 'name' => 'Mexican Peso', 'symbol' => '$'],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => 'S$'],
            ['code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => 'HK$'],
            ['code' => 'NZD', 'name' => 'New Zealand Dollar', 'symbol' => 'NZ$'],
            ['code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr'],
            ['code' => 'KRW', 'name' => 'South Korean Won', 'symbol' => '₩'],
            ['code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr'],
            ['code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr'],
            ['code' => 'PLN', 'name' => 'Polish Złoty', 'symbol' => 'zł'],
            ['code' => 'CZK', 'name' => 'Czech Koruna', 'symbol' => 'Kč'],
            ['code' => 'HUF', 'name' => 'Hungarian Forint', 'symbol' => 'Ft'],
            ['code' => 'RUB', 'name' => 'Russian Ruble', 'symbol' => '₽'],
            ['code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => '₺'],
            ['code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R'],
            ['code' => 'THB', 'name' => 'Thai Baht', 'symbol' => '฿'],
            ['code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM'],
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp'],
            ['code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => '₱'],
            ['code' => 'VND', 'name' => 'Vietnamese Dong', 'symbol' => '₫'],
            ['code' => 'NGN', 'name' => 'Nigerian Naira', 'symbol' => '₦'],
            ['code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => 'E£'],
            ['code' => 'KES', 'name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
            ['code' => 'GHS', 'name' => 'Ghanaian Cedi', 'symbol' => 'GH₵'],
            ['code' => 'UGX', 'name' => 'Ugandan Shilling', 'symbol' => 'USh'],
            ['code' => 'TZS', 'name' => 'Tanzanian Shilling', 'symbol' => 'TSh'],
        ];
    }
} 