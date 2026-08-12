<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\HomeSliderApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\DecorativeCategoryApiController;
use App\Http\Controllers\Api\ManufacturingSectionApiController;
use App\Http\Controllers\Api\NewsItemApiController;
use App\Http\Controllers\Api\NewArrivalsApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Client API Routes
Route::get('/clients', [ClientApiController::class, 'index']);
Route::get('/clients/{id}', [ClientApiController::class, 'show']);

// Home Slider API Routes
Route::get('/sliders', [HomeSliderApiController::class, 'index']);
Route::get('/sliders/{id}', [HomeSliderApiController::class, 'show']);

// Project API Routes
Route::get('/projects', [ProjectApiController::class, 'index']);
Route::get('/projects/slug/{slug}', [ProjectApiController::class, 'showBySlug']);
Route::get('/projects/{id}', [ProjectApiController::class, 'show']);

// Event/News API Routes
Route::get('/events', [EventApiController::class, 'index']);
Route::get('/events/{id}', [EventApiController::class, 'show']);

// Decorative Category API Routes
Route::get('/decorative-categories', [DecorativeCategoryApiController::class, 'index']);
Route::get('/decorative-categories/{slug}', [DecorativeCategoryApiController::class, 'show']);

// Manufacturing Section API Route
Route::get('/manufacturing-section', [ManufacturingSectionApiController::class, 'index']);

// News Items (cards)
Route::get('/news-items', [NewsItemApiController::class, 'index']);

// New Arrivals Products
Route::get('/products/new-arrivals', [NewArrivalsApiController::class, 'index']);
