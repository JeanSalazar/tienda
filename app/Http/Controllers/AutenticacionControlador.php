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
            'nombre' => 'required|string',
            'correo' => 'required|string|unique:usuarios,correo',
            'contrasena' => 'required|string|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
        ]);

        return response()->json($usuario, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|string',
            'contrasena' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('correo', 'contrasena'))) {
            return response()->json(['mensaje' => 'Credenciales incorrectas'], 401);
        }

        $usuario = $request->user();
        $token = $usuario->createToken('token-name')->plainTextToken;

        return response()->json(['usuario' => $usuario, 'token' => $token], 200);
    }
    
    public function olvidoContrasena(Request $request)
    {
        $request->validate(['correo' => 'required|email']);

        $status = Password::sendResetLink($request->only('correo'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['mensaje' => 'Enlace de recuperación enviado'], 200)
            : response()->json(['error' => 'No se pudo enviar el enlace'], 500);
    }


}
