<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioRolPermisoControlador extends Controller
{
    public function asignarRol(Request $request, $userId)
    {
        $user = Usuario::findOrFail($userId);
        $role = Rol::findByName($request->role);
        $user->assignRole($role);
        return response()->json(['message' => 'Rol asignado correctamente'], 200);
    }

    public function quitarRol(Request $request, $userId)
    {
        $user = Usuario::findOrFail($userId);
        $role = Rol::findByName($request->role);
        $user->removeRole($role);
        return response()->json(['message' => 'Rol eliminado correctamente'], 200);
    }

    public function asignarPermiso(Request $request, $userId)
    {
        $user = Usuario::findOrFail($userId);
        $permission = Permiso::findByName($request->permission);
        $user->givePermissionTo($permission);
        return response()->json(['message' => 'Permiso asignado correctamente'], 200);
    }

    public function quitarPermiso(Request $request, $userId)
    {
        $user = Usuario::findOrFail($userId);
        $permission = Permiso::findByName($request->permission);
        $user->revokePermissionTo($permission);
        return response()->json(['message' => 'Permiso eliminado correctamente'], 200);
    }
}
