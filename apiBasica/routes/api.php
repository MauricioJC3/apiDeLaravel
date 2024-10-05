<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProviderController;

Route::apiResource('products', ProductController::class);
Route::apiResource('providers', ProviderController::class);