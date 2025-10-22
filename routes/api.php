<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('tickets/{id}/resolve', [TicketController::class, 'resolve']);
    Route::put('tickets/{id}/close', [TicketController::class, 'close']);
});

Route::apiResource('tickets', TicketController::class)->middleware('auth:sanctum');

// Tokens
Route::delete('/delete-tokens', [AuthController::class, 'removeTokens']);
