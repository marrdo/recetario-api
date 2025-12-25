<?php

use App\Auth\Abilities;
use App\Http\Controllers\Api\AlimentoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// LOGEO
Route::post('/login', [AuthController::class, 'login']);

// Protegemos rutas con usuarios autenticados con el middleware
Route::get('/usuarios', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Asignamos el middleware de sanctum para tener protegdas las rutas.
Route::middleware('auth:sanctum')->group(function () {
    // Deslogeamos al usuario, por tanto debe venir con un token
    Route::post('/logout', [AuthController::class, 'logout']);

    // Manejo de los alimentos segun el TOKEN
    Route::middleware('abilities:manejo-alimentos')->group(function () {

        Route::apiResource('alimentos', AlimentoController::class);

    });

    // Ejemplo de ruta para ver al usuario logeado(ejemplo)
    Route::get('/me', function (Request $request) {
        return $request->user()->load('roles'); /*Este load que carajo hace?*/
    });

    // Probando la entrada a la ruta segun las abilities del TOKEN.
    Route::middleware('abilities:' . Abilities::ADMIN_PANEL)->group(function () {
        Route::get('/admin/ping', fn () => 'ok admin');
    });

});