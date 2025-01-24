<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreateCaseController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ManageCasesController;
use App\Http\Controllers\CreateReportController;
use App\Http\Controllers\ManageReportsController;
use App\Http\Controllers\ManageActivitiesController;
use App\Http\Controllers\RegisterActivityController;




Route::get('/', [HomeController::class, 'index'])->name('home');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports/create', [CreateReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [CreateReportController::class, 'store'])->name('reports.store');
    Route::get('/activities', [ManageActivitiesController::class, 'index'])->name('activities.index');
    Route::get('/activities/{id}', [ManageActivitiesController::class, 'show'])->name('activities.show');
    Route::get('/activities/create', [RegisterActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [RegisterActivityController::class, 'store'])->name('activities.store');
    Route::get('/list_pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/view/{page}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/cases/create', [CreateCaseController::class, 'create'])->name('cases.create');
    Route::post('/cases', [CreateCaseController::class, 'store'])->name('cases.store');
    Route::get('/reports/{id}', [ManageReportsController::class, 'show'])->name('reports.show');
    Route::get('/cases', [ManageCasesController::class, 'index'])->name('cases.index');
    Route::get('/cases/{id}', [ManageCasesController::class, 'show'])->name('cases.show');  // Add this route
    Route::get('/reports', [ManageReportsController::class, 'index'])->name('reports.index');
    Route::get('/list_pages', [PageController::class, 'index'])->name('pages.index');

    // User Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/users', [UsersController::class, 'index'])->name('user.index');
    });

    //Pages Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/create', [PageController::class, 'store'])->name('pages.store');
        Route::get('/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/edit/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/delete/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    });


    //Activity Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/activities/{id}/edit', [ManageActivitiesController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{id}', [ManageActivitiesController::class, 'update'])->name('activities.update');
        Route::delete('/activities/{id}', [ManageActivitiesController::class, 'destroy'])->name('activities.destroy');
        Route::post('/activities/{id}/approve', [ManageActivitiesController::class, 'approve'])->name('activities.approve');
        Route::post('/activities/{id}/decline', [ManageActivitiesController::class, 'decline'])->name('activities.decline');
    });


    // Case Management Routes
    Route::middleware('checkrole:admin')->group(function () {
        Route::get('/cases/{id}/edit', [ManageCasesController::class, 'edit'])->name('cases.edit');
        Route::put('/cases/{id}', [ManageCasesController::class, 'update'])->name('cases.update');
        Route::delete('/cases/{id}', [ManageCasesController::class, 'destroy'])->name('cases.destroy');
    });

    Route::middleware('checkrole:admin')->group(function () {
        // Routes for managing reports (ManageReportsController)
        Route::get('/reports/{id}/edit', [ManageReportsController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ManageReportsController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{id}', [ManageReportsController::class, 'destroy'])->name('reports.destroy');

        // Additional routes for updating the report status (ManageReportsController)
        Route::put('/reports/{id}/status', [ManageReportsController::class, 'updateStatus'])->name('reports.update-status'); // Correct route name here
    });

    // Statistics Routes
    Route::middleware('checkrole:admin,organization')->group(function () {
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        Route::post('/statistics/download', [StatisticsController::class, 'downloadReport'])->name('statistics.download');
    });








    require_once 'profile.php';
});


require __DIR__ . '/auth.php';
