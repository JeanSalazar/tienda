<?php

use App\Http\Controllers\AutenticacionControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;

// Autenticación
Route::post('registro', [AutenticacionControlador::class, 'registro']);
Route::post('login', [AutenticacionControlador::class, 'login']);
Route::post('olvido-contrasena', [AutenticacionControlador::class, 'olvidoContrasena']);

// Productos
Route::apiResource('productos', ProductoController::class);

// Ordenes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('ordenes', OrdenController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::get('ordenes/{id}/boleta', [OrdenController::class, 'generarBoleta']);


});

// Pagos
Route::post('pagar', [PagoController::class, 'pagar']);