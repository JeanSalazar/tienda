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
use App\Http\Controllers\RolPermisoControlador;
use App\Http\Controllers\UsuarioRolPermisoControlador;

// Autenticación
Route::post('registro', [AutenticacionControlador::class, 'registro']);
Route::post('login', [AutenticacionControlador::class, 'login'])->name('login');
Route::post('olvido-contrasena', [AutenticacionControlador::class, 'olvidoContrasena']);







Route::apiResource('permisos', PermisoControlador::class);
Route::apiResource('roles', RolControlador::class);

Route::post('roles/{rolId}/permisos/asignar', [RolPermisoControlador::class, 'asignarPermisos']);
Route::delete('roles/{rolId}/permisos/{permisoId}', [RolPermisoControlador::class, 'quitarPermiso']);
Route::get('roles/{rolId}/permisos', [RolPermisoControlador::class, 'mostrarPermisos']);

Route::apiResource('categorias', CategoriaController::class);
//Route::apiResource('usuarios', UsuarioControlador::class);

// Ordenes
Route::middleware('auth:sanctum')->group(function () {


    Route::apiResource('ordenes', OrdenController::class);

    // Productos
    Route::apiResource('productos', ProductoController::class);

    Route::get('ordenes/{id}/boleta', [OrdenController::class, 'generarBoleta']);

    // Pagos
    Route::post('pagar', [PagoController::class, 'pagar']);
});
