<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\SubcategoryController;

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
    // REFRESH TOKEN 
    Route::post('refresh', [AuthController::class, 'refreshToken']);
    // LOGOUT
    Route::post('logout', [AuthController::class, 'logout']);
    // UPDATE PASSWORD
    Route::post('change-password', [AuthController::class, 'updatePassword']);

    // CREATE CATEGORY
    Route::post('store-category', [CategoryController::class, 'store']);
    // GET CATEGORY PAGINATION
    Route::get('get-category', [CategoryController::class, 'index']);
    //GET CATEGORY LIST
    Route::get('get-category-list', [CategoryController::class, 'list']);
    // UPDATE CATEGORY 
    Route::put('categories/{category}/update', [CategoryController::class, 'update']);
    // DELETE CATEGORY
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // CREATE SUBCATEGORY
    Route::post('store-subcategory', [SubcategoryController::class, 'store']);
    // GET SUBCATEGORY
    Route::get('get-subcategory', [SubcategoryController::class, 'index']);
    // UPDATE SUBCATEGORY 
    Route::put('sub-categories/{subCategory}/update', [SubcategoryController::class, 'update']);
    // DELETE SUBCATEGORY
    Route::delete('sub-categories/{subCategory}', [SubcategoryController::class, 'destroy']);

    // CREATE IMAGE
    Route::post('create-image', [ImageController::class, 'store']);
    // GET IMAGES
    Route::get('images', [ImageController::class, 'index']);
    // EDIT IMAGE 
    Route::get('images/{image}/edit', [ImageController::class, 'edit']);
    // UPDATE IMAGE 
    Route::put('images/{image}/update', [ImageController::class, 'update']);
    // DELETE IMAGE
    Route::delete('images/{image}', [ImageController::class, 'destroy']);

    //GET ACCOUNT
    Route::get('get-accounts', [AccountController::class, 'index']);
    // DELETE IMAGE
    Route::delete('accounts/{account}', [AccountController::class, 'destroy']);
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(NewPasswordController::class)->group(function () {
    Route::post('forgot-passwor', 'forgotPassword');
});
