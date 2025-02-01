<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaControlador extends Controller
{
    // Listar todas las categorías
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    // Mostrar una categoría específica
    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'La categoría no fue encontrada.'
            ], 404);
        }

        return response()->json($categoria);
    }

    // Crear una nueva categoría
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'descripcion' => 'required|string|unique:categorias,descripcion',
        ], [
            'descripcion.required' => 'La descripción de la categoría es obligatoria.',
            'descripcion.unique' => 'La descripción de la categoría ya existe.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto válida.',
        ]);

        // Crear la nueva categoría
        $categoria = Categoria::create([
            'descripcion' => $request->descripcion,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json($categoria, 201);
    }

    // Actualizar una categoría existente
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'descripcion' => 'sometimes|string|unique:categorias,descripcion,' . $id,
        ], [
            'descripcion.sometimes' => 'La descripción de la categoría es opcional, pero debe ser válida si se proporciona.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto válida.',
            'descripcion.unique' => 'La descripción de la categoría ya existe.',
        ]);

        // Buscar la categoría por ID
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'La categoría no fue encontrada.'
            ], 404);
        }

        // Actualizar la categoría
        $categoria->update([
            'descripcion' => $request->descripcion,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json($categoria, 200);
    }

    // Eliminar una categoría
    public function destroy($id)
    {
        // Buscar la categoría por ID
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'La categoría no fue encontrada.'
            ], 404);
        }

        // Eliminar los productos asociados a esta categoría (si es necesario)
        Producto::where('categoria_id', $id)->delete();

        // Eliminar la categoría
        $categoria->delete();

        return response()->json([
            'message' => 'Categoria eliminada correctamente.'
        ], 200);
    }
}
