<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AdminController::class, 'listUsers']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/user', [UserController::class, 'update'])->middleware('can:update,user');
    Route::delete('/user/{user}', [UserController::class, 'delete'])->middleware('role:admin');
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    
    Route::post('/users', [AdminController::class, 'createUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
});
