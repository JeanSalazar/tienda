<?php

use App\Http\Controllers\AutenticacionControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaControlador;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteControlador;
use App\Http\Controllers\CuponControlador;
use App\Http\Controllers\DireccionControlador;
use App\Http\Controllers\LogControlador;
use App\Http\Controllers\OrdenControlador;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PermisoControlador;
use App\Http\Controllers\ProductoControlador;
use App\Http\Controllers\ResenaControlador;
use App\Http\Controllers\RolControlador;
use App\Http\Controllers\RolPermisoControlador;
use App\Http\Controllers\UsuarioControlador;
use App\Http\Controllers\UsuarioRolPermisoControlador;

// Autenticación
Route::post('registro', [AutenticacionControlador::class, 'registro']);
Route::post('login', [AutenticacionControlador::class, 'login'])->name('login');
Route::post('olvido-contrasena', [AutenticacionControlador::class, 'olvidoContrasena']);











// Ordenes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logs', [LogControlador::class, 'crearLog']);
    Route::get('logs', [LogControlador::class, 'obtenerLogs']);

    Route::apiResource('permisos', PermisoControlador::class);
    Route::apiResource('roles', RolControlador::class);

    Route::post('roles/{rolId}/permisos/asignar', [RolPermisoControlador::class, 'asignarPermisos']);
    Route::delete('roles/{rolId}/permisos/{permisoId}', [RolPermisoControlador::class, 'quitarPermiso']);
    Route::get('roles/{rolId}/permisos', [RolPermisoControlador::class, 'mostrarPermisos']);

    Route::apiResource('categorias', CategoriaControlador::class);
    Route::apiResource('usuarios', UsuarioControlador::class);

    Route::apiResource('clientes', ClienteControlador::class);
    Route::apiResource('productos', ProductoControlador::class);
    Route::apiResource('cupones', CuponControlador::class);
    Route::get('productos/categoria/{categoria_id}', [ProductoControlador::class, 'productosPorCategoria']);
    Route::apiResource('resenas', ResenaControlador::class);
    Route::get('resenas/cliente/{clienteId}', [ResenaControlador::class, 'resenasPorCliente']);
    Route::get('resenas/producto/{productoId}', [ResenaControlador::class, 'resenasPorProducto']);
    Route::apiResource('direcciones', DireccionControlador::class);
    Route::post('ubigeos/importar', [DireccionControlador::class, 'importarCsv']);
    Route::get('/clientes/{cliente_id}/direcciones', [DireccionControlador::class, 'direccionesPorCliente']);

    Route::apiResource('ordenes', OrdenControlador::class);
    Route::get('ordenes/cliente/{cliente_id}', [OrdenControlador::class, 'ordenesPorCliente']);
    Route::get('ordenes/{id}/boleta', [OrdenControlador::class, 'generarBoleta']);
    Route::post('ordenes/{id}/pagar', [OrdenControlador::class, 'pagarConCulqi']);

    Route::get('ordenes/{id}/boleta', [OrdenControlador::class, 'generarBoleta']);
    Route::post('pagar', [PagoController::class, 'pagar']);
});
