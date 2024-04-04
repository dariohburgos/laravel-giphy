<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as User;
use App\Http\Controllers\GiphyController;
use App\Http\Middleware\LogInteraction;

Route::middleware([LogInteraction::class])->group(function () {
    Route::post('login', [
        App\Http\Controllers\Api\LoginController::class,
        'login'
    ]);

    // Definir la ruta 'user' que devuelve la información del usuario autenticado
    Route::get('user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    // Definir la ruta 'giphy/search' para buscar gifs (sin autenticación requerida)
    Route::get('giphy/search', [GiphyController::class, 'search'])->middleware('auth:sanctum');

    // Definir la ruta 'favorite-gif' para almacenar gifs favoritos (requiere autenticación)
    Route::post('/favorite-gif', [GiphyController::class, 'storeFavoriteGif'])->middleware('auth:sanctum');
});
