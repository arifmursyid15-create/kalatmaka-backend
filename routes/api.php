<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\KatalogController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SettingController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/home', [HomeController::class, 'index']);

Route::get('/portfolio', [PortfolioController::class, 'index']);
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show']);

Route::get('/katalog', [KatalogController::class, 'index']);
Route::get('/katalog/{slug}', [KatalogController::class, 'show']);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/settings', [SettingController::class, 'index']);

// =====================
// AUTH
// =====================
Route::post('/admin/login', [AuthController::class, 'login']);

// =====================
// ADMIN ROUTES (protected)
// =====================
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Upload
    Route::post('/upload', [UploadController::class, 'upload']);

    // Banner
    Route::get('/banners', [BannerController::class, 'index']);
    Route::post('/banners', [BannerController::class, 'store']);
    Route::put('/banners/{id}', [BannerController::class, 'update']);
    Route::delete('/banners/{id}', [BannerController::class, 'destroy']);

    // Portfolio
    Route::get('/portfolio', [PortfolioController::class, 'adminIndex']);
    Route::post('/portfolio', [PortfolioController::class, 'store']);
    Route::put('/portfolio/{id}', [PortfolioController::class, 'update']);
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy']);

    // Katalog
    Route::get('/katalog', [KatalogController::class, 'adminIndex']);
    Route::post('/katalog', [KatalogController::class, 'store']);
    Route::put('/katalog/{id}', [KatalogController::class, 'update']);
    Route::delete('/katalog/{id}', [KatalogController::class, 'destroy']);

    // Blog
    Route::get('/blog', [BlogController::class, 'adminIndex']);
    Route::post('/blog', [BlogController::class, 'store']);
    Route::put('/blog/{id}', [BlogController::class, 'update']);
    Route::delete('/blog/{id}', [BlogController::class, 'destroy']);

    // Testimonial
    Route::get('/testimonials', [TestimonialController::class, 'adminIndex']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);

    // Category
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update']);
});
