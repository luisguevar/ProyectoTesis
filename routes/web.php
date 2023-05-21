<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportesController;
use App\Http\Livewire\ShoppingCart;
use App\Http\Livewire\CreateOrder;
use App\Http\Controllers\WebhooksController;
use App\Http\Livewire\PaymentOrder;
use App\Models\Order;


Route::get('/', WelcomeController::class); //No necesitamos colocar nada porque el invoke ya le avisa
Route::get('search', searchController::class)->name('search');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::get('/generar-pdf', 'ReportesController@generarPDF');


//Grupo middlware para acceder solo si estás logueado
Route::middleware(['auth'])->group(function () {
    //Solo para gente logueada
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', CreateOrder::class)->middleware('auth')->name('orders.create');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    /* Route::get('orders/{order}/payment',[OrderController::class, 'payment'] )->name('orders.payment'); */
    Route::get('orders/{order}/payment', PaymentOrder::class)->name('orders.payment');
    Route::get('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('webhooks', WebhooksController::class);
});

Route::post('reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');

