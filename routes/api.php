<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\ItemApiController;
use App\Http\Controllers\Api\V1\ItemTypeApiController;
use App\Http\Controllers\Api\V1\BuildingApiController;
use App\Http\Controllers\Api\V1\RoomApiController;
use App\Http\Controllers\Api\V1\TransactionTypeApiController;
use App\Http\Controllers\Api\V1\InventoryApiController;
use App\Http\Controllers\Api\V1\InventoryRoomApiController;
use App\Http\Controllers\Api\V1\InventoryTransactionApiController;
use App\Http\Controllers\Api\V1\InventoryTransactionDetailApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use App\Http\Controllers\Api\V1\DashboardApiController;
use App\Http\Controllers\Api\V1\ReportApiController;

Route::prefix('v1')
    ->as('api.v1.')
    ->group(function () {

        Route::post('/login', [AuthApiController::class, 'login'])->name('login');

        Route::middleware('auth:sanctum')->group(function () {

            Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');

            Route::get('/dashboard', [DashboardApiController::class, 'index'])->name('dashboard');

            Route::get('/reports/stock', [ReportApiController::class, 'stock'])->name('reports.stock');
            Route::get('/reports/transactions', [ReportApiController::class, 'transactions'])->name('reports.transactions');
            Route::get('/reports/budget', [ReportApiController::class, 'budget'])->name('reports.budget');

            Route::apiResource('item-types', ItemTypeApiController::class);
            Route::apiResource('items', ItemApiController::class);
            Route::apiResource('buildings', BuildingApiController::class);
            Route::apiResource('rooms', RoomApiController::class);
            Route::apiResource('transaction-types', TransactionTypeApiController::class);
            Route::apiResource('inventories', InventoryApiController::class);
            Route::apiResource('inventory-rooms', InventoryRoomApiController::class);
            Route::apiResource('transactions', InventoryTransactionApiController::class);
            Route::apiResource('transaction-details', InventoryTransactionDetailApiController::class);
            Route::apiResource('users', UserApiController::class);
        });
    });