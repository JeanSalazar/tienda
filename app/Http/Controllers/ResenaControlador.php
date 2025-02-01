<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;

class ResenaControlador extends Controller
{
    /**
     * Mostrar todas las reseñas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las reseñas con los productos y clientes relacionados
        $resenas = Resena::with(['producto', 'cliente'])->get();
        return response()->json($resenas);
    }

    public function resenasPorCliente($clienteId)
    {
        // Obtener las reseñas de un cliente específico con el producto relacionado
        $resenas = Resena::with('producto')->where('cliente_id', $clienteId)->get();
        return response()->json($resenas);
    }

    public function resenasPorProducto($productoId)
    {
        // Obtener las reseñas de un producto específico con el cliente relacionado
        $resenas = Resena::with('cliente')->where('producto_id', $productoId)->get();
        return response()->json($resenas);
    }

    /**
     * Crear una nueva reseña.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'calificacion' => 'required|in:1,2,3,4,5',
            'comentario' => 'nullable|string',
        ]);

        // Crear la reseña
        $resena = Resena::create([
            'producto_id' => $request->producto_id,
            'cliente_id' => $request->cliente_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Reseña creada con éxito',
            'resena' => $resena
        ], 201);
    }

    /**
     * Mostrar una reseña específica por ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Obtener la reseña por ID con los productos y clientes relacionados
        $resena = Resena::with(['producto', 'cliente'])->find($id);

        if (!$resena) {
            return response()->json(['mensaje' => 'Reseña no encontrada'], 404);
        }

        return response()->json($resena);
    }

    /**
     * Actualizar una reseña existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'calificacion' => 'required|in:1,2,3,4,5',
            'comentario' => 'nullable|string',
        ]);

        // Buscar la reseña
        $resena = Resena::find($id);

        if (!$resena) {
            return response()->json(['mensaje' => 'Reseña no encontrada'], 404);
        }

        // Actualizar la reseña
        $resena->update([
            'producto_id' => $request->producto_id,
            'cliente_id' => $request->cliente_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Reseña actualizada con éxito',
            'resena' => $resena
        ]);
    }

    /**
     * Eliminar una reseña.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar la reseña
        $resena = Resena::find($id);

        if (!$resena) {
            return response()->json(['mensaje' => 'Reseña no encontrada'], 404);
        }

        // Eliminar la reseña
        $resena->delete();

        return response()->json(['mensaje' => 'Reseña eliminada con éxito']);
    }
}
