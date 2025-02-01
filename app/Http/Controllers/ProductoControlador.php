<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoControlador extends Controller
{
    /**
     * Mostrar todos los productos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return response()->json($productos);
    }

    /**
     * Crear un nuevo producto.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'caracteristicas' => 'required|string',
            'precio' => 'required|numeric',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'precio' => $request->precio,
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
     * Mostrar un producto específico por ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    /**
     * Actualizar un producto existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'caracteristicas' => 'required|string',
            'precio' => 'required|numeric',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Actualizar el producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'caracteristicas' => $request->caracteristicas,
            'precio' => $request->precio,
            'categoria_id' => $request->categoria_id,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Producto actualizado con éxito',
            'producto' => $producto
        ]);
    }

    /**
     * Eliminar un producto.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        // Eliminar el producto
        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado con éxito']);
    }
}
