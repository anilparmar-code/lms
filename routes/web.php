<?php

use App\Livewire\LeavesIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('leaves', LeavesIndex::class)->name('leaves.index');
});

require __DIR__.'/settings.php';
