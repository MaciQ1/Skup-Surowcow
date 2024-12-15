<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(MaterialController::class)->group(function () {
    Route::get('/materials', 'index')->name('materials.index');
    Route::get('/offers', 'offers')->name('materials.offers');
    Route::get('/materials/{id}', 'show')->name('materials.show');
    Route::get('/materials/{id}/edit', 'edit')->name('materials.edit');
    Route::put('/materials/{id}', 'update')->name('materials.update');
});

Route::controller(OrderController::class)->group(function () {
    Route::post('/materials/order', 'store')->name('materials.store');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'login')->name('login');
    Route::post('/auth/login', 'authenticate')->name('login.authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::resource('admin/users', UserController::class, ['as' => 'admin']);
    Route::resource('admin/materials', MaterialController::class, ['as' => 'admin']);
    Route::resource('admin/orders', OrderController::class, ['as' => 'admin']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/panel/{id}', [UserController::class, 'panel'])->name('user.panel');
    Route::resource('user/profile', UserController::class, ['as' => 'user']);
    Route::resource('user/orders', OrderController::class, ['as' => 'user']);
});
