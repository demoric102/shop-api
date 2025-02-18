<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\OrderList;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
    Route::get('/admin/products', ProductManager::class)->name('admin.products');
    Route::get('/admin/orders', OrderList::class)->name('admin.orders');
});

