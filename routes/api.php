<?php

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Users
Route::post('/users/register', [UserController::class, 'register']);
Route::get('/users/list', [UserController::class, 'findAll']);

// Transactions
Route::post('/transactions/createTransaction', [TransactionsController::class, 'createTransaction']);
