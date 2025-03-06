<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('');




// routes/api.php
Route::get('/product-requisition', [ProductController::class, 'search']);

Route::get('/supplier-order', [SupplierController::class, 'search']);

