<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Orden;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeliveryControlador extends Controller
{
    // Mostrar todos los registros de delivery
    public function index()
    {
        $deliveries = Delivery::all();
        return response()->json($deliveries);
    }

    // Mostrar un registro específico
    public function show($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'Delivery no encontrado'], 404);
        }

        return response()->json($delivery);
    }

    // Crear un nuevo delivery
    public function store(Request $request)
    {
        $request->validate([
            'orden_id' => 'required|exists:ordenes,id',
            'direccion_id' => 'required|exists:direcciones,id',
            'fecha_envio' => 'required|date',
            'fecha_entrega_estimada' => 'required|date',
        ]);

        $delivery = new Delivery();
        $delivery->orden_id = $request->orden_id;
        $delivery->direccion_id = $request->direccion_id;
        $delivery->estado = 1; // Enviado
        $delivery->fecha_envio = Carbon::parse($request->fecha_envio);
        $delivery->fecha_entrega_estimada = Carbon::parse($request->fecha_entrega_estimada);
        $delivery->fecha_creacion = Carbon::now();
        $delivery->fecha_actualizacion = Carbon::now();

        $delivery->save();

        return response()->json(['message' => 'Delivery creado exitosamente', 'delivery' => $delivery], 201);
    }

    // Actualizar un delivery
    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'Delivery no encontrado'], 404);
        }

        $request->validate([
            'estado' => 'required|in:1,2',  // 1: Enviado, 2: Recibido
            'fecha_entrega_real' => 'required|date',
        ]);

        $delivery->estado = $request->estado;
        $delivery->fecha_entrega_real = Carbon::parse($request->fecha_entrega_real);
        $delivery->fecha_actualizacion = Carbon::now();

        $delivery->save();

        return response()->json(['message' => 'Delivery actualizado exitosamente', 'delivery' => $delivery]);
    }

    // Eliminar un delivery
    public function destroy($id)
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json(['message' => 'Delivery no encontrado'], 404);
        }

        $delivery->delete();

        return response()->json(['message' => 'Delivery eliminado exitosamente']);
    }
}
