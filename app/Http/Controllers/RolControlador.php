<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolControlador extends Controller
{
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|unique:roles,descripcion',
        ], [
            'descripcion.unique' => 'El rol ya existe.',
            'descripcion.required' => 'La descripción del rol es obligatoria.',
        ]);

        $rol = Rol::create(['descripcion' => $request->descripcion]);
        return response()->json($rol, 201);
    }

    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'El rol no fue encontrado.'
            ], 404);
        }

        return response()->json($rol, 200);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'El rol no fue encontrado.'
            ], 404);
        }

        $request->validate([
            'descripcion' => 'required|unique:roles,descripcion,' . $id,
        ], [
            'descripcion.unique' => 'El rol ya existe.',
            'descripcion.required' => 'La descripción del rol es obligatoria.',
        ]);

        $rol->update($request->only('descripcion'));

        return response()->json($rol, 200);
    }

    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'El rol no fue encontrado.'
            ], 404);
        }

        $rol->delete();

        return response()->json([
            'message' => 'Rol eliminado correctamente.'
        ], 200);
    }
}
