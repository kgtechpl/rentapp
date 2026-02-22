<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('kategorie')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('show');
});

Route::get('/sprzet/{equipment:slug}', [EquipmentController::class, 'show'])->name('equipment.show');

Route::prefix('kontakt')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/', [ContactController::class, 'store'])->name('store');
});

// Auth routes
Route::get('/admin/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/admin/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/admin/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
        ->except(['show']);

    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EquipmentController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\EquipmentController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\EquipmentController::class, 'store'])->name('store');
        Route::get('/{equipment}/edit', [\App\Http\Controllers\Admin\EquipmentController::class, 'edit'])->name('edit');
        Route::put('/{equipment}', [\App\Http\Controllers\Admin\EquipmentController::class, 'update'])->name('update');
        Route::delete('/{equipment}', [\App\Http\Controllers\Admin\EquipmentController::class, 'destroy'])->name('destroy');
        Route::patch('/{equipment}/toggle-visibility', [\App\Http\Controllers\Admin\EquipmentController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::patch('/{equipment}/mark-rented', [\App\Http\Controllers\Admin\EquipmentController::class, 'markRented'])->name('mark-rented');
        Route::patch('/{equipment}/mark-available', [\App\Http\Controllers\Admin\EquipmentController::class, 'markAvailable'])->name('mark-available');
        Route::post('/{equipment}/media', [\App\Http\Controllers\Admin\EquipmentController::class, 'uploadMedia'])->name('media.upload');
        Route::delete('/{equipment}/media/{media}', [\App\Http\Controllers\Admin\EquipmentController::class, 'deleteMedia'])->name('media.delete');
    });

    Route::prefix('inquiries')->name('inquiries.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('index');
        Route::get('/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'show'])->name('show');
        Route::patch('/{inquiry}/status', [\App\Http\Controllers\Admin\InquiryController::class, 'updateStatus'])->name('update-status');
    });

    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
