<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


<<<<<<< HEAD
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
=======
// Ticket routes protected by authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class);
>>>>>>> 0e1873ad092ad6ea681c134ca79c6e54ce4c613c
});
