<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('products.list'); 
});

    Route::middleware(['CheckAdmin'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.list');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');


    Route::post('/import-products', [ProductController::class, 'importProducts'])->name('import.products');
    Route::get('/export-products', [ProductController::class, 'exportProducts'])->name('export.products');

    Route::get('/export', [ProductController::class, 'export'])->name('export');
Route::post('/import', [ProductController::class, 'import'])->name('import');

});