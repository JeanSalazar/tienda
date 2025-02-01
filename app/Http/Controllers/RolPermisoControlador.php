<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolPermisoControlador extends Controller
{
    // Asocia permisos a un rol
    public function asignarPermisos(Request $request, $rolId)
    {
        $rol = Rol::find($rolId);

        if (!$rol) {
            return response()->json([
                'message' => 'El rol no fue encontrado.'
            ], 404);
        }

        $request->validate([
            'permisos' => 'required|array', // Asegurarse de que se envíe un array de permisos
            'permisos.*' => 'exists:permisos,id', // Verifica que cada ID de permiso exista en la tabla permisos
        ]);

        // Asocia los permisos al rol
        $rol->permisos()->sync($request->permisos); // sync reemplaza la asociación existente
        return response()->json([
            'message' => 'Permisos asignados al rol correctamente.',
            'rol' => $rol,
            'permisos' => $rol->permisos
        ], 200);
    }

    // Elimina un permiso de un rol
    public function quitarPermiso($rolId, $permisoId)
    {
        $rol = Rol::find($rolId);
        $permiso = Permiso::find($permisoId);

        if (!$rol || !$permiso) {
            return response()->json([
                'message' => 'El rol o el permiso no fue encontrado.'
            ], 404);
        }

        // Elimina la relación entre el rol y el permiso
        $rol->permisos()->detach($permisoId);

        return response()->json([
            'message' => 'Permiso eliminado del rol correctamente.'
        ], 200);
    }

    // Muestra todos los permisos de un rol
    public function mostrarPermisos($rolId)
    {
        $rol = Rol::find($rolId);

        if (!$rol) {
            return response()->json([
                'message' => 'El rol no fue encontrado.'
            ], 404);
        }

        return response()->json($rol->permisos, 200);
    }
}
