<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoControlador extends Controller
{
    /**
     * Obtener todos los productos.
     */
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    /**
     * Crear un nuevo producto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'caracteristicas' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Producto creado con éxito',
            'producto' => $producto
        ], 201);
    }

    /**
     * Obtener un producto por su ID.
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'El producto no fue encontrado.'
            ], 404);
        }

        return response()->json($producto);
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'El producto no fue encontrado.'
            ], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'caracteristicas' => 'sometimes|string',
            'precio' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $producto->update($request->all());
        $producto->fecha_actualizacion = now();
        $producto->save();

        return response()->json([
            'mensaje' => 'Producto actualizado con éxito',
            'producto' => $producto
        ]);
    }

    /**
     * Eliminar un producto.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'El producto no fue encontrado.'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente.'
        ], 200);
    }

    /**
     * Obtener productos según categoría.
     */
    public function productosPorCategoria($categoria_id)
    {
        $productos = Producto::where('categoria_id', $categoria_id)->get();
        return response()->json($productos);
    }
}
