<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    // Route::apiResource('shipment', ShipmentController::class);
    Route::put('shipment/{shipment}', [ShipmentController::class, 'update']);
    Route::delete('shipment/{shipment}', [ShipmentController::class, 'destroy']);

    Route::get('logout', [AuthController::class, 'logout']);
});
Route::get('shipment', [ShipmentController::class, 'index']);
Route::post('shipment', [ShipmentController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
