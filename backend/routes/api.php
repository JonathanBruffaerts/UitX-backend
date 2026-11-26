<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/me', [AuthController::class, 'me'])->name('me.show');

    Route::patch('/me', [AuthController::class, 'updateMe'])->name('me.update');

    Route::get('/users', function () {
        return response()->json(['message' => 'Not implemented'], 501);
    })->name('users.index');

    Route::get('/friends', function () {
        return response()->json(['message' => 'Not implemented'], 501);
    })->name('friends.index');

    Route::post('/friends/{user}', function (string $user) {
        return response()->json(['message' => 'Not implemented', 'user' => $user], 501);
    })->name('friends.request');

    Route::post('/friends/{user}/accept', function (string $user) {
        return response()->json(['message' => 'Not implemented', 'user' => $user], 501);
    })->name('friends.accept');

    Route::delete('/friends/{user}', function (string $user) {
        return response()->json(['message' => 'Not implemented', 'user' => $user], 501);
    })->name('friends.destroy');

    Route::get('/me/events', function () {
        return response()->json(['message' => 'Not implemented'], 501);
    })->name('me.events');

    Route::post('/events/{eventId}/going', function (string $eventId) {
        return response()->json(['message' => 'Not implemented', 'eventId' => $eventId], 501);
    })->name('events.going.store');

    Route::delete('/events/{eventId}/going', function (string $eventId) {
        return response()->json(['message' => 'Not implemented', 'eventId' => $eventId], 501);
    })->name('events.going.destroy');

    Route::post('/events/{eventId}/save', function (string $eventId) {
        return response()->json(['message' => 'Not implemented', 'eventId' => $eventId], 501);
    })->name('events.save.store');

    Route::delete('/events/{eventId}/save', function (string $eventId) {
        return response()->json(['message' => 'Not implemented', 'eventId' => $eventId], 501);
    })->name('events.save.destroy');

    Route::get('/friends/events', function () {
        return response()->json(['message' => 'Not implemented'], 501);
    })->name('friends.events');
});

Route::get('/events', function () {
    return response()->json(['message' => 'Not implemented'], 501);
})->name('events.index');

Route::get('/events/{eventId}', function (string $eventId) {
    return response()->json(['message' => 'Not implemented', 'eventId' => $eventId], 501);
})->name('events.show');
