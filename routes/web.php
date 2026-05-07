<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryRoomController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/', [FrontendController::class, 'dashboard'])->name('dashboard');

    // INVENTORY - STAFF & ADMIN VIEW
    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');

    // TRANSACTIONS - STAFF & ADMIN
    Route::resource('transactions', InventoryTransactionController::class)
        ->only(['index', 'create', 'store', 'show']);

    // REPORTS
    Route::get('/reports', [FrontendController::class, 'reports'])->name('reports.index');
    Route::get('/reports/pdf', [FrontendController::class, 'exportPdf'])->name('reports.pdf');

    // UI PAGES
    Route::view('/notifications', 'pages.notifications')->name('notifications.index');
    Route::view('/help', 'pages.help')->name('help.index');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings.index');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/permissions', [ProfileController::class, 'updatePermissions'])->name('permissions.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // USERS
        Route::resource('users', UserController::class)->except(['show']);

        // MASTER DATA
        Route::resource('item-types', ItemTypeController::class)->except(['show']);
        Route::resource('items', ItemController::class)->except(['show']);
        Route::resource('buildings', BuildingController::class)->except(['show']);
        Route::resource('rooms', RoomController::class)->except(['show']);
        Route::resource('transaction-types', TransactionTypeController::class)->except(['show']);

        // INVENTORY - ADMIN FULL ACCESS
        Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
        Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
        Route::get('/inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
        Route::put('/inventories/{inventory}', [InventoryController::class, 'update'])->name('inventories.update');
        Route::delete('/inventories/{inventory}', [InventoryController::class, 'destroy'])->name('inventories.destroy');
        Route::get('/inventories/{inventory}/print', [InventoryController::class, 'print'])->name('inventories.print');

        // DISTRIBUTION
        Route::resource('inventory-rooms', InventoryRoomController::class)->except(['show']);
    });
});

require __DIR__ . '/auth.php';
