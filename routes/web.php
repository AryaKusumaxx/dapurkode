<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CheckoutController;
#use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
#use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Halaman Statis
use App\Http\Controllers\PageController;
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service');

// UI Improvements Guide
Route::get('/ui-guide', [PageController::class, 'uiGuide'])->name('ui-guide');

// Auth routes
require __DIR__.'/auth.php';

// Public checkout routes
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/check-discount', [CheckoutController::class, 'checkDiscount'])->name('checkout.check-discount');

// Customer routes
Route::middleware(['auth', 'active'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.password.form');
    Route::put('/change-password', [UserController::class, 'changePassword'])->name('user.password.update');
    
    // Orders & Invoices
    Route::get('/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/invoices', [UserController::class, 'invoices'])->name('user.invoices');
    
    // Warranties
    Route::get('/warranties', [UserController::class, 'warranties'])->name('user.warranties');
    Route::get('/warranties/{warranty}', [\App\Http\Controllers\WarrantyController::class, 'show'])->name('user.warranty.show');
    Route::get('/warranties/{warranty}/extend', [\App\Http\Controllers\WarrantyController::class, 'showExtendForm'])->name('user.warranty.extend');
    Route::post('/warranties/{warranty}/extend', [\App\Http\Controllers\WarrantyController::class, 'extend'])->name('user.warranty.extend.process');
    Route::get('/warranty-extension/{extension}/payment', [\App\Http\Controllers\WarrantyController::class, 'showExtensionPayment'])->name('user.warranty.extension.payment');
    Route::post('/warranty-extension/{extension}/payment', [\App\Http\Controllers\WarrantyController::class, 'processExtensionPayment'])->name('user.warranty.extension.payment.process');
    Route::get('/warranties/{warranty}/download', [\App\Http\Controllers\WarrantyController::class, 'download'])->name('user.warranty.download');
    
    // Process checkout (requires authentication)
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/{invoice}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{invoice}', [PaymentController::class, 'store'])->name('payment.store');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'active', 'role:admin|superadmin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User management
    Route::resource('users', AdminUserController::class);
    Route::put('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::put('users/{user}/password', [AdminUserController::class, 'updatePassword'])->name('users.update-password');
    
    // Product management
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('editor-test', function() {
        return view('admin.products.editor-test');
    })->name('products.editor-test');
    
    // Order management
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Payment verification
    Route::get('payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
    Route::match(['post', 'put'], 'payments/{payment}/verify', [App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('payments/{payment}/reject', [App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
    
    // Invoice management
    Route::get('invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{invoice}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('invoices.show');
    
    // Warranty management
    Route::get('warranties', [App\Http\Controllers\Admin\WarrantyController::class, 'index'])->name('warranties.index');
    Route::get('warranties/{warranty}', [App\Http\Controllers\Admin\WarrantyController::class, 'show'])->name('warranties.show');
    Route::put('warranties/{warranty}/status', [App\Http\Controllers\Admin\WarrantyController::class, 'updateStatus'])->name('warranties.update-status');
    Route::put('warranties/{warranty}/add-note', [App\Http\Controllers\Admin\WarrantyController::class, 'addNote'])->name('warranties.add-note');
    Route::post('warranties/{warranty}/extend', [App\Http\Controllers\Admin\WarrantyController::class, 'extend'])->name('warranties.extend');
    Route::get('warranties/{warranty}/download', [App\Http\Controllers\Admin\WarrantyController::class, 'download'])->name('warranties.download');
});

// Superadmin routes - only accessible by superadmin
Route::prefix('superadmin')->middleware(['auth', 'active', 'role:superadmin'])->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');
    
    // Role & Permission Management
    Route::resource('roles', App\Http\Controllers\Superadmin\RoleController::class);
    
    // Audit Log
    Route::get('audit-logs', [App\Http\Controllers\Superadmin\AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/{auditLog}', [App\Http\Controllers\Superadmin\AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::post('audit-logs/export', [App\Http\Controllers\Superadmin\AuditLogController::class, 'export'])->name('audit-logs.export');
    Route::delete('audit-logs', [App\Http\Controllers\Superadmin\AuditLogController::class, 'clear'])->name('audit-logs.clear');
    
    // System Settings
    Route::get('settings', [App\Http\Controllers\Superadmin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [App\Http\Controllers\Superadmin\SettingController::class, 'update'])->name('settings.update');
    
    // Database Backup
    Route::get('backups', [App\Http\Controllers\Superadmin\BackupController::class, 'index'])->name('backups.index');
    Route::post('backups', [App\Http\Controllers\Superadmin\BackupController::class, 'create'])->name('backups.create');
    Route::get('backups/{backup}/download', [App\Http\Controllers\Superadmin\BackupController::class, 'download'])->name('backups.download');
    Route::get('backups/{backup}/restore', [App\Http\Controllers\Superadmin\BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('backups/{backup}', [App\Http\Controllers\Superadmin\BackupController::class, 'destroy'])->name('backups.destroy');
    Route::post('backups/settings', [App\Http\Controllers\Superadmin\BackupController::class, 'settings'])->name('backups.settings');
});
