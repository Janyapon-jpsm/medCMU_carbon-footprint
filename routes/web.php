<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard-em');
});

Route::get('/carbon-footprint-MedCMU-dashboard-em', function () {
    return view('dashboard-em');
});

Route::get('/carbon-footprint-MedCMU-dashboard-re', function () {
    return view('dashboard-re');
});
