<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogControlador extends Controller
{
    /**
     * Crear un nuevo log con el usuario autenticado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function crearLog(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'accion' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // Obtener el usuario autenticado
        $usuario_id = Auth::id();

        // Crear el log
        $log = Log::create([
            'usuario_id' => $usuario_id,
            'accion' => $request->accion,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Log creado con éxito',
            'log' => $log
        ], 201);
    }

    /**
     * Obtener todos los logs de un usuario autenticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerLogs()
    {
        // Obtener el usuario autenticado
        $usuario_id = Auth::id();

        // Obtener los logs del usuario
        $logs = Log::where('usuario_id', $usuario_id)->get();

        return response()->json($logs);
    }
}
