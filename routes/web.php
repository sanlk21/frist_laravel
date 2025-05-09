<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('Customer', function () {
    return Inertia::render('Customer');
})->middleware(['auth', 'verified'])->name('Customer');

Route::get('Invoice', function () {
    return Inertia::render('Invoice');
})->middleware(['auth', 'verified'])->name('Invoice');

Route::get('Proposal', function () {
    return Inertia::render('Proposal');
})->middleware(['auth', 'verified'])->name('Proposal');

Route::get('Transaction', function () {
    return Inertia::render('Transaction');
})->middleware(['auth', 'verified'])->name('Transaction');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('invoices', InvoiceController::class)->except(['show']);
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
});


Route::middleware(['auth', 'verified'])->group(function () {
    // ... existing routes ...
    Route::resource('proposals', ProposalController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('customers', CustomerController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('transactions', TransactionController::class)->except(['show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
