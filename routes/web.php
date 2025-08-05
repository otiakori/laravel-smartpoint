<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\InstallmentPlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierPaymentController;

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
    
    // Installment Plan routes
    Route::resource('installment-plans', InstallmentPlanController::class);
    Route::post('/installment-plans/{installmentPlan}/payments', [InstallmentPlanController::class, 'processPayment'])->name('installment-plans.process-payment');
    Route::post('/installment-plans/{installmentPlan}/schedule/{paymentSchedule}/pay', [InstallmentPlanController::class, 'paySchedule'])->name('installment-plans.pay-schedule');
    Route::get('/installment-plans/overdue', [InstallmentPlanController::class, 'overdue'])->name('installment-plans.overdue');
    Route::get('/installment-plans/due-today', [InstallmentPlanController::class, 'dueToday'])->name('installment-plans.due-today');
    Route::get('/installment-plans/statistics', [InstallmentPlanController::class, 'statistics'])->name('installment-plans.statistics');
    
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
    
    // Sales management routes
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales-statistics', [SaleController::class, 'statistics'])->name('sales.statistics');
    
    // Profit analysis routes
    Route::get('/profit', [ProfitController::class, 'index'])->name('profit.index');
    Route::get('/profit/export', [ProfitController::class, 'export'])->name('profit.export');
    
    // Settings routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

// Chat Bot routes
Route::get('/chat', function () {
    return view('chat');
})->name('chat.index');

// Invoice management routes
Route::resource('invoices', InvoiceController::class);
Route::post('/invoices/{invoice}/mark-as-sent', [InvoiceController::class, 'markAsSent'])->name('invoices.mark-as-sent');
Route::post('/invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
Route::post('/invoices/{invoice}/mark-as-cancelled', [InvoiceController::class, 'markAsCancelled'])->name('invoices.mark-as-cancelled');
Route::post('/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');

// Role management routes
Route::resource('roles', RoleController::class);

// User management routes
Route::resource('users', UserController::class);

// Supplier management routes
Route::resource('suppliers', SupplierController::class);
Route::get('/suppliers/{supplier}/purchase-orders', [SupplierController::class, 'purchaseOrders'])->name('suppliers.purchase-orders');
Route::get('/suppliers/{supplier}/payments', [SupplierController::class, 'payments'])->name('suppliers.payments');

// Purchase Order management routes
Route::resource('purchase-orders', PurchaseOrderController::class);
Route::post('/purchase-orders/{purchaseOrder}/send', [PurchaseOrderController::class, 'send'])->name('purchase-orders.send');
Route::post('/purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase-orders.cancel');

// Supplier Payment management routes
Route::resource('supplier-payments', SupplierPaymentController::class);
Route::get('/supplier-payments/{supplier}/history', [SupplierPaymentController::class, 'history'])->name('supplier-payments.history');
});
