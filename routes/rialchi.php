<?php

use App\Http\Controllers\Rialchi\HomeController;
use App\Http\Controllers\Rialchi\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('rialchi.home');
Route::get('/tracking', TrackingController::class)->name('rialchi.tracking');
