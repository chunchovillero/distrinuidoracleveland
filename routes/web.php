<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispatchTypeController;
use Illuminate\Support\Facades\Auth;

// Rutas del catálogo público
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{product}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog/{product}/whatsapp', [CatalogController::class, 'generateWhatsAppMessage'])->name('catalog.whatsapp');
Route::get('/api/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');

// Rutas administrativas (solo administradores autenticados)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:superadmin,admin,seller'])->group(function () {
    
    // Dashboard con permiso específico
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view_dashboard');
    
    // Manual del sistema
    Route::get('/manual', function() {
        return view('manual.index');
    })->name('manual.index');
    
    // Configuración del sistema
    Route::get('/configuration', [App\Http\Controllers\SystemConfigurationController::class, 'index'])->name('configuration.index')->middleware('role:superadmin');
    Route::put('/configuration', [App\Http\Controllers\SystemConfigurationController::class, 'update'])->name('configuration.update')->middleware('role:superadmin');
    
    // Consulta de ventas con permisos específicos
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index')->middleware('permission:view_sales');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create')->middleware('permission:create_sales');
    Route::get('sales/export-config', [SaleController::class, 'showExportConfig'])->name('sales.export-config')->middleware('permission:export_sales');
    Route::post('sales/export-config', [SaleController::class, 'saveExportConfig'])->name('sales.save-export-config')->middleware('permission:export_sales');
    Route::post('sales/export', [SaleController::class, 'exportSales'])->name('sales.export')->middleware('permission:export_sales');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show')->middleware('permission:view_sales');
    Route::get('sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf')->middleware('permission:view_sales');
    Route::patch('sales/{sale}/authorize', [SaleController::class, 'authorizeSale'])->name('sales.authorize')->middleware('role:superadmin,admin');

    // Tipos de despacho
    Route::get('dispatch-types', [DispatchTypeController::class, 'index'])->name('dispatch-types.index')->middleware('permission:view_categories');
    Route::get('dispatch-types/create', [DispatchTypeController::class, 'create'])->name('dispatch-types.create')->middleware('permission:create_categories');
    Route::post('dispatch-types', [DispatchTypeController::class, 'store'])->name('dispatch-types.store')->middleware('permission:create_categories');
    Route::get('dispatch-types/{dispatchType}/edit', [DispatchTypeController::class, 'edit'])->name('dispatch-types.edit')->middleware('permission:edit_categories');
    Route::put('dispatch-types/{dispatchType}', [DispatchTypeController::class, 'update'])->name('dispatch-types.update')->middleware('permission:edit_categories');
    Route::patch('dispatch-types/{dispatchType}/toggle-status', [DispatchTypeController::class, 'toggleStatus'])->name('dispatch-types.toggle-status')->middleware('permission:edit_categories');
    Route::delete('dispatch-types/{dispatchType}', [DispatchTypeController::class, 'destroy'])->name('dispatch-types.destroy')->middleware('permission:delete_categories');
    
    // Consultas básicas con permisos específicos
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('permission:view_customers');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create')->middleware('permission:create_customers');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show')->middleware('permission:view_customers');
    Route::get('/api/customers/search', [CustomerController::class, 'search'])->name('customers.search')->middleware('permission:view_customers');
    
    Route::get('products', [ProductController::class, 'index'])->name('products.index')->middleware('permission:view_products');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:create_products');
    Route::get('products/export-config', [ProductController::class, 'showExportConfig'])->name('products.export-config')->middleware('permission:view_products');
    Route::post('products/export-config', [ProductController::class, 'saveExportConfig'])->name('products.save-export-config')->middleware('permission:view_products');
    Route::post('products/export', [ProductController::class, 'exportProducts'])->name('products.export')->middleware('permission:view_products');
    Route::get('products/export-simple', [ProductController::class, 'exportProductsSimple'])->name('products.export-simple')->middleware('permission:view_products');
    Route::post('products/import', [ProductController::class, 'importProducts'])->name('products.import')->middleware('permission:create_products');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('permission:view_products');
    Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search')->middleware('permission:view_products');
    
    // Vendedores - create ANTES de {seller}
    Route::get('sellers', [SellerController::class, 'index'])->name('sellers.index')->middleware('permission:view_sellers');
    Route::get('sellers/create', [SellerController::class, 'create'])->name('sellers.create')->middleware('permission:create_sellers');
    Route::get('sellers/{seller}', [SellerController::class, 'show'])->name('sellers.show')->middleware('permission:view_sellers');
    
    // Categorías - create ANTES de {category}
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('permission:view_categories');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:create_categories');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show')->middleware('permission:view_categories');
    
    // Reportes con permisos específicos
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales')->middleware('permission:view_reports_sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventoryReport'])->name('reports.inventory')->middleware('permission:view_reports_inventory');
    Route::get('/reports/customers', [ReportController::class, 'customersReport'])->name('reports.customers')->middleware('permission:view_reports_customers');
    Route::get('/reports/monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly')->middleware('permission:view_reports_monthly');
    Route::get('/reports/commissions', [ReportController::class, 'commissionsReport'])->name('reports.commissions')->middleware('permission:view_reports_commissions');
    Route::get('/reports/calidad', [ReportController::class, 'calidadReport'])->name('reports.calidad')->middleware('permission:view_reports_calidad');

    // Gestión de Calidades
    Route::get('calidad', [\App\Http\Controllers\CalidadController::class, 'index'])->name('calidad.index')->middleware('permission:view_categories');
    Route::get('calidad/create', [\App\Http\Controllers\CalidadController::class, 'create'])->name('calidad.create')->middleware('permission:create_categories');
    Route::post('calidad', [\App\Http\Controllers\CalidadController::class, 'store'])->name('calidad.store')->middleware('permission:create_categories');
    Route::get('calidad/{calidad}', [\App\Http\Controllers\CalidadController::class, 'show'])->name('calidad.show')->middleware('permission:view_categories');
    Route::get('calidad/{calidad}/edit', [\App\Http\Controllers\CalidadController::class, 'edit'])->name('calidad.edit')->middleware('permission:edit_categories');
    Route::put('calidad/{calidad}', [\App\Http\Controllers\CalidadController::class, 'update'])->name('calidad.update')->middleware('permission:edit_categories');
    Route::delete('calidad/{calidad}', [\App\Http\Controllers\CalidadController::class, 'destroy'])->name('calidad.destroy')->middleware('permission:delete_categories');

    // Gestión de Proveedores
    Route::get('proveedores', [\App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores.index')->middleware('permission:view_customers');
    Route::get('proveedores/create', [\App\Http\Controllers\ProveedorController::class, 'create'])->name('proveedores.create')->middleware('permission:create_customers');
    Route::post('proveedores', [\App\Http\Controllers\ProveedorController::class, 'store'])->name('proveedores.store')->middleware('permission:create_customers');
    Route::get('proveedores/{proveedor}', [\App\Http\Controllers\ProveedorController::class, 'show'])->name('proveedores.show')->middleware('permission:view_customers');
    Route::get('proveedores/{proveedor}/edit', [\App\Http\Controllers\ProveedorController::class, 'edit'])->name('proveedores.edit')->middleware('permission:edit_customers');
    Route::put('proveedores/{proveedor}', [\App\Http\Controllers\ProveedorController::class, 'update'])->name('proveedores.update')->middleware('permission:edit_customers');
    Route::delete('proveedores/{proveedor}', [\App\Http\Controllers\ProveedorController::class, 'destroy'])->name('proveedores.destroy')->middleware('permission:delete_customers');
    Route::patch('proveedores/{proveedor}/toggle-status', [\App\Http\Controllers\ProveedorController::class, 'toggleStatus'])->name('proveedores.toggle-status')->middleware('permission:edit_customers');

    // Productos - Acciones específicas
    Route::post('products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:create_products');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:edit_products');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:edit_products');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:delete_products');
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status')->middleware('permission:toggle_products');

    // Clientes - Acciones específicas (solo las que faltan)
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store')->middleware('permission:create_customers');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('permission:edit_customers');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update')->middleware('permission:edit_customers');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('permission:delete_customers');
    Route::patch('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status')->middleware('permission:toggle_customers');

    // Vendedores - Acciones específicas (solo las que faltan)
    Route::post('sellers', [SellerController::class, 'store'])->name('sellers.store')->middleware('permission:create_sellers');
    Route::get('sellers/{seller}/edit', [SellerController::class, 'edit'])->name('sellers.edit')->middleware('permission:edit_sellers');
    Route::put('sellers/{seller}', [SellerController::class, 'update'])->name('sellers.update')->middleware('permission:edit_sellers');
    Route::delete('sellers/{seller}', [SellerController::class, 'destroy'])->name('sellers.destroy')->middleware('permission:delete_sellers');
    Route::patch('sellers/{seller}/toggle-status', [SellerController::class, 'toggleStatus'])->name('sellers.toggle-status')->middleware('permission:toggle_sellers');

    // Categorías - Acciones específicas (solo las que faltan)
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:create_categories');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:edit_categories');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:edit_categories');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:delete_categories');
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status')->middleware('permission:toggle_categories');

    // Ventas - Acciones específicas
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store')->middleware('permission:create_sales');
    Route::get('sales/{sale}/duplicate', [SaleController::class, 'duplicate'])->name('sales.duplicate')->middleware('permission:duplicate_sales');
    Route::patch('sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel')->middleware('permission:cancel_sales');
    Route::delete('sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('permission:delete_sales');
    Route::get('/api/products/{id}/details', [SaleController::class, 'getProductDetails'])->name('products.details');

    // Rutas solo para administradores (gestión de usuarios)
    Route::middleware('role:superadmin')->group(function () {
        // Gestión de usuarios
        Route::resource('users', UserController::class);
        Route::get('profile', fn () => redirect()->route('admin.users.edit', auth()->user()))->name('profile');
        Route::get('users/role/{role}', [UserController::class, 'byRole'])->name('users.by-role');
        
        // Gestión de permisos de usuarios
        Route::get('users/{user}/permissions', [App\Http\Controllers\UserPermissionController::class, 'edit'])->name('users.permissions.edit');
        Route::put('users/{user}/permissions', [App\Http\Controllers\UserPermissionController::class, 'update'])->name('users.permissions.update');
        Route::get('users/{user}/permissions/grant-all', [App\Http\Controllers\UserPermissionController::class, 'grantAll'])->name('users.permissions.grant-all');
        Route::get('users/{user}/permissions/revoke-all', [App\Http\Controllers\UserPermissionController::class, 'revokeAll'])->name('users.permissions.revoke-all');
    });

});

// Rutas de autenticación dentro del prefijo admin
Route::prefix('admin')->group(function () {
    Auth::routes(['register' => false]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
