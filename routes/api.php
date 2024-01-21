<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserTController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\ReviewController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserTController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/auth', [UserTController::class, 'getUserByToken']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/tickets/{id}', [TicketController::class, 'show']);

Route::post('/events/create', [EventController::class, 'store']);

Route::post('/purchase-history/create', [PurchaseHistoryController::class, 'store']);
Route::post('/purchase-history', [PurchaseHistoryController::class, 'index']);

Route::post('/reviews', [ReviewController::class, 'store']);







