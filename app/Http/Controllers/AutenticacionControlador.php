<?php

namespace App\Http\Controllers;

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
        ]);

        // Verificar si el correo ya está registrado
        if (Usuario::where('correo', $request->correo)->exists()) {
            return response()->json(['error' => 'El correo ya está registrado.'], 422);
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena), // Asegúrate de usar Hash::make
        ]);

        return response()->json($usuario, 201);
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
            'email' => 'required|email|exists:usuarios,correo'
        ]);

        $status = Password::sendResetLink([
            'email' => $request->email
        ]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Correo de recuperación enviado.'])
            : response()->json(['error' => 'No se pudo enviar el correo.'], 400);
    }
}
