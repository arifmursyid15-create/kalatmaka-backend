<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\TestimoniController;
use App\Http\Controllers\Api\SettingController;

Route::get('/portfolios', [PortfolioController::class, 'index']);
Route::get('/testimonis', [TestimoniController::class, 'index']);
Route::get('/settings', [SettingController::class, 'index']);