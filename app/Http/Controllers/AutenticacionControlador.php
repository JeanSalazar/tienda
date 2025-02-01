<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class AutenticacionControlador extends Controller
{
    public function registro(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'correo' => 'required|string|email',
            'celular' => 'nullable|string|regex:/^[0-9]{9}$/',
            'contrasena' => 'required|string|confirmed',
            'nro_documento' => 'required|string',
        ]);

        // Verificar si el correo ya está registrado
        if (Usuario::where('correo', $request->correo)->exists()) {
            return response()->json(['error' => 'El correo ya está registrado.'], 422);
        }

        // Crear el usuario
        $usuario = Usuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena), // Asegúrate de usar Hash::make
            'estado' => 1, // Estado predeterminado activo
            'rol_id' => 1, // Suponiendo que se asigna un rol por defecto, puedes cambiarlo según tus necesidades
        ]);

        // Crear el cliente asociado al usuario
        $cliente = Cliente::create([
            'usuario_id' => $usuario->id,
            'nro_documento' => $request->nro_documento,
            'celular' => $request->celular,
        ]);

        return response()->json([
            'usuario' => $usuario,
            'cliente' => $cliente
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|string',
            'contrasena' => 'required|string',
        ]);

        // Buscar al usuario por correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return response()->json(['mensaje' => 'Credenciales incorrectas'], 401);
        }

        // Generar token de autenticación
        $token = $usuario->createToken('token-name')->plainTextToken;

        return response()->json(['usuario' => $usuario, 'token' => $token], 200);
    }

    public function olvidoContrasena(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|exists:usuarios,correo'
        ]);

        $status = Password::sendResetLink([
            'email' => $request->correo
        ]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Correo de recuperación enviado.'])
            : response()->json(['error' => 'No se pudo enviar el correo.'], 400);
    }
}
