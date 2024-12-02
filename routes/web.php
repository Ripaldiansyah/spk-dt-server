<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DecisionTreeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRecommendationController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\UserController;
use App\Services\DecisionTreeService;
use Illuminate\Support\Facades\Route;

Route::prefix('/api')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
    Route::prefix('train')->group(function () {
        Route::get('/', [TrainController::class, 'index']);
        Route::post('/', [TrainController::class, 'store']);
        Route::put('/{id}', [TrainController::class, 'update']);
        Route::delete('/{id}', [TrainController::class, 'destroy']);
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::prefix('predict')->group(function () {
        Route::post('/', [DecisionTreeController::class, 'predictWithRecommendations']);
        Route::get('/report', [DecisionTreeController::class, 'downloadReport']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
