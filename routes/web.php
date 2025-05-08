<?php

use Illuminate\Support\Facades\Route;
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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
