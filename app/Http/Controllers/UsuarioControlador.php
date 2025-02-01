<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioControlador extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'El usuario no fue encontrado.'
            ], 404);
        }

        return response()->json($usuario);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6|confirmed',
            'rol_id' => 'nullable|exists:roles,id',
            'estado' => 'nullable|in:1,2,3', // 1: Activo, 2: Inactivo, 3: Eliminado
        ], [
            'correo.unique' => 'El correo ya está registrado.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear el nuevo usuario
        $usuario = Usuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'rol_id' => $request->rol_id,
            'estado' => $request->estado ?? 1, // Predeterminado a Activo
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json($usuario, 201);
    }

    // Actualizar un usuario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'correo' => ['sometimes', 'email', Rule::unique('usuarios')->ignore($id)],
            'contrasena' => 'sometimes|string|min:6|confirmed',
            'rol_id' => 'nullable|exists:roles,id',
            'estado' => 'nullable|in:1,2,3',
        ], [
            'correo.unique' => 'El correo ya está registrado.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Buscar el usuario por ID
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'El usuario no fue encontrado.'
            ], 404);
        }

        // Actualizar el usuario
        $usuario->update([
            'nombres' => $request->nombres ?? $usuario->nombres,
            'apellidos' => $request->apellidos ?? $usuario->apellidos,
            'correo' => $request->correo ?? $usuario->correo,
            'contrasena' => $request->contrasena ? Hash::make($request->contrasena) : $usuario->contrasena,
            'rol_id' => $request->rol_id ?? $usuario->rol_id,
            'estado' => $request->estado ?? $usuario->estado,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json($usuario, 200);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        // Buscar el usuario por ID
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'El usuario no fue encontrado.'
            ], 404);
        }

        // Eliminar el usuario
        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente.'
        ], 200);
    }
}
