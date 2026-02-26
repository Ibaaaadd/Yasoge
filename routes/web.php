<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SepatuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceInController;
use App\Http\Controllers\InvoiceOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('Auth/login');
});


Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


    Route::get('/invoicein', [InvoiceInController::class, 'index'])->name('invoiceIn.index');
    Route::get('/invoicein/create', [InvoiceInController::class, 'create'])->name('invoiceIn.create');
    Route::get('/invoicein/{id}/edit', [InvoiceInController::class, 'edit'])->name('invoiceIn.edit');
    Route::post('/invoicein', [InvoiceInController::class, 'store'])->name('invoiceIn.store');
    Route::put('/invoicein/{id}', [InvoiceInController::class, 'update'])->name('invoiceIn.update');
    Route::delete('/invoicein/{id}', [InvoiceInController::class, 'destroy'])->name('invoiceIn.destroy');

    Route::get('/invoiceout', [InvoiceOutController::class, 'index'])->name('invoiceOut.index');
    Route::get('/invoiceout/create', [InvoiceOutController::class, 'create'])->name('invoiceOut.create');
    Route::post('/invoiceout', [InvoiceOutController::class, 'store'])->name('invoiceOut.store');
    Route::get('/invoiceout/{id}/edit', [InvoiceOutController::class, 'edit'])->name('invoiceOut.edit');
    Route::put('/invoiceout/{id}', [InvoiceOutController::class, 'update'])->name('invoiceOut.update');
    Route::delete('/invoiceout/{id}', [InvoiceOutController::class, 'destroy'])->name('invoiceOut.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/sepatu', [SepatuController::class, 'index'])->name('sepatu.index');
    Route::post('/sepatu', [SepatuController::class, 'store'])->name('sepatu.store');
    Route::put('/sepatu/{id}', [SepatuController::class, 'update'])->name('sepatu.update');
    Route::delete('/sepatu/{id}', [SepatuController::class, 'destroy'])->name('sepatu.destroy');
    Route::get('/sepatu/download/{id}', [SepatuController::class, 'download'])->name('sepatu.download');

    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::resource('users', UserController::class);


    Route::middleware(['auth', 'user-access:user'])->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');
    });

    Route::middleware(['auth', 'user-access:admin'])->group(function () {
        // Route untuk dashboard admin
        Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    });

    Route::middleware(['auth', 'user-access:manager'])->group(function () {

        Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
