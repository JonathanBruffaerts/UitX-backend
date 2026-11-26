<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserEventController;
use Illuminate\Support\Facades\Route;

// Accounts (publiek)
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Events (publiek)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{eventId}', [EventController::class, 'show'])->name('events.show');

// Beveiligde routes (Sanctum token vereist)
Route::middleware('auth:sanctum')->group(function () {
    // Account
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me.show');
    Route::patch('/me', [AuthController::class, 'updateMe'])->name('me.update');

    // Vrienden
    Route::get('/users', [FriendController::class, 'indexUsers'])->name('users.index');
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{user}', [FriendController::class, 'request'])->name('friends.request');
    Route::post('/friends/{user}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::delete('/friends/{user}', [FriendController::class, 'destroy'])->name('friends.destroy');

    // Mijn events & vrienden-events
    Route::get('/me/events', [UserEventController::class, 'index'])->name('me.events');
    Route::post('/events/{eventId}/going', [UserEventController::class, 'setGoing'])->name('events.going.store');
    Route::delete('/events/{eventId}/going', [UserEventController::class, 'unsetGoing'])->name('events.going.destroy');
    Route::post('/events/{eventId}/save', [UserEventController::class, 'save'])->name('events.save.store');
    Route::delete('/events/{eventId}/save', [UserEventController::class, 'unsave'])->name('events.save.destroy');
    Route::get('/friends/events', [UserEventController::class, 'friendsEvents'])->name('friends.events');
});
