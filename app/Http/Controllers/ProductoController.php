<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;



class ProductoController extends Controller
{
    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio_base' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Calcular el precio_final
        $precio_final = $request->precio_base * 1.18;

        // Crear el producto con el precio_final calculado
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_base' => $request->precio_base,
            'precio_final' => $precio_final,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
        ]);

        return response()->json($producto, 201);
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return response()->json($producto, 200);
    }

    public function destroy($id)
    {
        Producto::destroy($id);
        return response()->json(null, 204);
    }
}
