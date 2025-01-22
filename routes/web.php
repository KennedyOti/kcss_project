<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreateCaseController;
use App\Http\Controllers\ManageCasesController;
use App\Http\Controllers\ManageActivitiesController;
use App\Http\Controllers\RegisterActivityController;

//Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UsersController::class, 'index'])->name('user.index');
    // Activity Routes
    Route::middleware('checkrole:admin')->group(function () {
        // Route to display the form to register a new activity
        Route::get('/activities/create', [RegisterActivityController::class, 'create'])->name('activities.create');

        // Route to handle form submission for storing a new activity
        Route::post('/activities', [RegisterActivityController::class, 'store'])->name('activities.store');
    });


    //Pages Management Routes
    Route::middleware('checkrole:admin,')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('pages.index');
        Route::get('/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/create', [PageController::class, 'store'])->name('pages.store');
        Route::get('/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/edit/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/delete/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
        Route::get('/view/{page}', [PageController::class, 'show'])->name('pages.show'); // View page route
    });


    //Activity Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/activities', [ManageActivitiesController::class, 'index'])->name('activities.index');
        Route::get('/activities/{id}', [ManageActivitiesController::class, 'show'])->name('activities.show');
        Route::get('/activities/{id}/edit', [ManageActivitiesController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{id}', [ManageActivitiesController::class, 'update'])->name('activities.update');
        Route::delete('/activities/{id}', [ManageActivitiesController::class, 'destroy'])->name('activities.destroy');
        Route::post('/activities/{id}/approve', [ManageActivitiesController::class, 'approve'])->name('activities.approve');
        Route::post('/activities/{id}/decline', [ManageActivitiesController::class, 'decline'])->name('activities.decline');
    });


    //Case Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/cases', [ManageCasesController::class, 'index'])->name('cases.index');
        Route::get('/cases/create', [CreateCaseController::class, 'create'])->name('cases.create');
        Route::post('/cases', [CreateCaseController::class, 'store'])->name('cases.store');
        Route::get('/cases/{id}/edit', [ManageCasesController::class, 'edit'])->name('cases.edit');
        Route::put('/cases/{id}', [ManageCasesController::class, 'update'])->name('cases.update');
        Route::delete('/cases/{id}', [ManageCasesController::class, 'destroy'])->name('cases.destroy');
    });





    require_once 'profile.php';
});


require __DIR__ . '/auth.php';
