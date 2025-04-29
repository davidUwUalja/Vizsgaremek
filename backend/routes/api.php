<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'store'])
    ->name('register.store');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('auth.authenticate');

Route::get('/users', [UserController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('users.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');
    

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber("id");
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update'])->whereNumber("id");
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->whereNumber("id");

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/user', [UserController::class, 'update'])->middleware('can:update,user');
    Route::delete('/user/{user}', [UserController::class, 'delete'])->middleware('role:admin')->whereNumber("user");
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'listUsers']);
    Route::post('/users', [AdminController::class, 'createUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->whereNumber("id");
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->whereNumber("id");
});

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show'])->whereNumber('id');
Route::put('/orders/{id}', [OrderController::class, 'update'])->whereNumber('id');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->whereNumber('id');

Route::get('/order-items', [OrderItemController::class, 'index']);
Route::post('/order-items', [OrderItemController::class, 'store']);
Route::get('/order-items/{id}', [OrderItemController::class, 'show'])->whereNumber('id');
Route::put('/order-items/{id}', [OrderItemController::class, 'update'])->whereNumber('id');
Route::delete('/order-items/{id}', [OrderItemController::class, 'destroy'])->whereNumber('id');
/**/