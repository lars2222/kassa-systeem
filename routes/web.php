<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\RecieptController;
use App\Http\Controllers\Admin\TaxRatesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/products', ProductController::class)->except(['show']); 
    Route::resource('/categories', CategoryController::class);
    Route::resource('/taxRates', TaxRatesController::class);
    Route::resource('/discounts', DiscountController::class);
    Route::get('/products/discount-products', [ProductController::class, 'discountProduct'])->name('products.discount-products');
    Route::post('/products/{product}/add-discount', [ProductController::class, 'addDiscount'])->name('products.addDiscount');
    Route::delete('/products/{product}/discounts/{discount}', [ProductController::class, 'removeDiscount'])->name('products.removeDiscount');
    Route::get('/products/product-stock', [ProductController::class, 'productStock'])->name('products.stock');
    Route::put('/products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
});

Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{productId}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/category/show/{categoryId}', [CategoryController::class, 'show'])->name('category.show');
Route::post('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/cart/reciept', [CartController::class, 'chooseReciept'])->name('cart.reciept');
Route::get('/receipt/{transactionId}', [ReceiptController::class, 'generatePdf'])->name('receipt.generatePdf');
Route::post('/cart/receipt-option', [CartController::class, 'handleReceiptOption'])->name('cart.receiptOption');
