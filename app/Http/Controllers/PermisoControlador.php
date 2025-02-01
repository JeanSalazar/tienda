<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoControlador extends Controller
{
    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|unique:permisos,descripcion',
        ], [
            'descripcion.unique' => 'El permiso ya existe.',
            'descripcion.required' => 'La descripción del permiso es obligatoria.',
        ]);

        $permiso = Permiso::create(['descripcion' => $request->descripcion]);
        return response()->json($permiso, 201);
    }

    public function show($id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json([
                'message' => 'El permiso no fue encontrado.'
            ], 404);
        }

        return response()->json($permiso, 200);
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json([
                'message' => 'El permiso no fue encontrado.'
            ], 404);
        }

        $request->validate([
            'descripcion' => 'required|unique:permisos,descripcion,' . $id,
        ], [
            'descripcion.unique' => 'El permiso ya existe.',
            'descripcion.required' => 'La descripción del permiso es obligatoria.',
        ]);

        $permiso->update($request->only('descripcion'));

        return response()->json($permiso, 200);
    }

    public function destroy($id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json([
                'message' => 'El permiso no fue encontrado.'
            ], 404);
        }

        $permiso->delete();

        return response()->json([
            'message' => 'Permiso eliminado correctamente.'
        ], 200);
    }
}
