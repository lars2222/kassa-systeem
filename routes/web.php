<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TaxRatesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/products', ProductController::class); 
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/taxRates', TaxRatesController::class);
    Route::resource('/admin/discounts', DiscountController::class);
    Route::get('/products/discount-products', [ProductController::class, 'discountProduct'])->name('products.discount-products');
    Route::post('/products/{product}/add-discount', [ProductController::class, 'addDiscount'])->name('products.addDiscount');
    Route::delete('/products/{product}/discounts/{discount}', [ProductController::class, 'removeDiscount'])->name('products.removeDiscount');
    Route::get('products/product-stock', [ProductController::class, 'productStock'])->name('products.stock');
    Route::put('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
});