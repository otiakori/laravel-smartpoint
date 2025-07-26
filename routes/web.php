<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
    
    // POS routes
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/search-products', [POSController::class, 'searchProducts'])->name('pos.search-products');
    Route::get('/pos/get-product/{product}', [POSController::class, 'getProduct'])->name('pos.get-product');
    Route::post('/pos/process-sale', [POSController::class, 'processSale'])->name('pos.process-sale');
    Route::get('/pos/receipt/{sale}', [POSController::class, 'showReceipt'])->name('pos.receipt');
    
    // Installment routes
    Route::get('/installments', [InstallmentController::class, 'index'])->name('installments.index');
    Route::get('/installments/create', [InstallmentController::class, 'create'])->name('installments.create');
    Route::post('/installments', [InstallmentController::class, 'store'])->name('installments.store');
    Route::get('/installments/{installmentSale}', [InstallmentController::class, 'show'])->name('installments.show');
    Route::post('/installments/{installmentSale}/payments', [InstallmentController::class, 'recordPayment'])->name('installments.record-payment');
    
    // Category management routes
    Route::resource('categories', CategoryController::class);

    // Inventory management routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{product}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{product}/restock', [InventoryController::class, 'restock'])->name('inventory.restock');
    Route::post('/inventory/{product}/restock', [InventoryController::class, 'processRestock'])->name('inventory.process-restock');
    Route::get('/inventory/{product}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
    Route::post('/inventory/{product}/adjust', [InventoryController::class, 'processStockAdjustment'])->name('inventory.process-adjustment');
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');
    Route::get('/inventory/movements', [InventoryController::class, 'movements'])->name('inventory.movements');
    
    // Product management routes
    Route::resource('products', ProductController::class);
    
    // Customer management routes
    Route::resource('customers', CustomerController::class);
    Route::get('/customers-api', [CustomerController::class, 'apiIndex'])->name('customers.api');
});
