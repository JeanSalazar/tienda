<?php

use App\Http\Controllers\AutenticacionControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PermisoControlador;
use App\Http\Controllers\RolControlador;
use App\Http\Controllers\UsuarioRolPermisoControlador;

// Autenticación
Route::post('registro', [AutenticacionControlador::class, 'registro']);
Route::post('login', [AutenticacionControlador::class, 'login'])->name('login');
Route::post('olvido-contrasena', [AutenticacionControlador::class, 'olvidoContrasena']);



Route::apiResource('permisos', PermisoControlador::class);
Route::apiResource('roles', RolControlador::class);

// Ordenes
Route::middleware('auth:sanctum')->group(function () {



    Route::apiResource('ordenes', OrdenController::class);
    Route::apiResource('categorias', CategoriaController::class);
    // Productos
    Route::apiResource('productos', ProductoController::class);

    Route::get('ordenes/{id}/boleta', [OrdenController::class, 'generarBoleta']);

    // Pagos
    Route::post('pagar', [PagoController::class, 'pagar']);



    // Asignar roles y permisos a usuarios
    Route::post('usuarios/{id}/asignar-rol', [UsuarioRolPermisoControlador::class, 'asignarRol']);
    Route::post('usuarios/{id}/quitar-rol', [UsuarioRolPermisoControlador::class, 'quitarRol']);
    Route::post('usuarios/{id}/asignar-permiso', [UsuarioRolPermisoControlador::class, 'asignarPermiso']);
    Route::post('usuarios/{id}/quitar-permiso', [UsuarioRolPermisoControlador::class, 'quitarPermiso']);
});
