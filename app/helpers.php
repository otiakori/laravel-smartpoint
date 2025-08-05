<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount) {
        if (!auth()->check()) {
            return '$' . number_format($amount, 2);
        }
        
        $tenant = auth()->user()->tenant;
        $symbol = $tenant->currency_symbol ?? '$';
        
        return $symbol . number_format($amount, 2);
    }
}

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol() {
        if (!auth()->check()) {
            return '$';
        }
        
        $tenant = auth()->user()->tenant;
        return $tenant->currency_symbol ?? '$';
    }
}

if (!function_exists('getCurrencyCode')) {
    function getCurrencyCode() {
        if (!auth()->check()) {
            return 'USD';
        }
        
        $tenant = auth()->user()->tenant;
        return $tenant->currency ?? 'USD';
    }
} 