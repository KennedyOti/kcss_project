<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route group with authentication middleware
Route::middleware(['auth'])->prefix('profile')->group(function () {
    // Display user profile form
    Route::get('/{id}', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update user profile
    Route::patch('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('password/{id}', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Delete user profile
    Route::delete('/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
