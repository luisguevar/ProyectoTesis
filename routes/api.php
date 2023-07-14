<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Image;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/productos', [ProductoController::class, 'index']);

Route::get('/orders', [ProductoController::class, 'orders']);

Route::get('/search/{id}', [ProductoController::class, 'search']);

Route::post('/orders', [ProductoController::class, 'store']);


Route::get('/categorias', [ProductoController::class, 'CategoriaProductos']);


