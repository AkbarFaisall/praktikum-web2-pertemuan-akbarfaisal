<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

// Rute pendaftaran dan login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Rute yang dilindungi Sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Rute kategori
    Route::apiResource('categories', CategoryController::class)->except(['destroy']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin');
    
    // Rute item (barang)
    Route::apiResource('items', ItemController::class)->except(['destroy']);
    Route::delete('items/{item}', [ItemController::class, 'destroy'])->middleware('role:admin');
    
});