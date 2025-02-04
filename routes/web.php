<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('dashboard-em');
});

Route::get('/carbon-footprint-MedCMU-dashboard-em', [DashboardController::class, 'showEmissionDashboard'])
    ->name('dashboard.emission');

Route::get('/carbon-footprint-MedCMU-dashboard-re', function () {
    return view('dashboard-re');
});

Route::get('/emission-detail', function () {
    return view('em-detail');
});
