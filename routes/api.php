<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NewPasswordController;

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

Route::middleware('auth:sanctum')->group(function () {
    // LOGIN
    Route::get('user', [AuthController::class, 'user']);
    // LOGOUT
    Route::get('logout', [AuthController::class, 'logout']);
    // UPDATE PASSWORD
    Route::post('change-password', [AuthController::class, 'updatePassword']);
    // CREATE CATEGORY
    Route::post('store-category', [CategoryController::class, 'store']);
    // GET CATEGORY ID
    Route::get('get-category', [CategoryController::class, 'index']);
    // CREATE IMAGE
    Route::post('store-image', [ImageController::class, 'store']);
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(NewPasswordController::class)->group(function () {
    Route::post('forgot-passwor', 'forgotPassword');
});
