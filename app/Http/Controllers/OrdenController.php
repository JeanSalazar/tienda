<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class OrdenController extends Controller
{
    public function index(Request $request)
    {
        return Orden::where('usuario_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $orden = Orden::create([
            'usuario_id' => $request->user()->id,
            'total' => $request->total,
            'fecha_entrega' => now()->addDays(5),
        ]);

        // Enviar correo
        Mail::to($request->user()->correo)->send(new \App\Mail\CompraRealizada($orden));

        return response()->json($orden, 201);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'total' => 'sometimes|numeric',
        'estado' => 'sometimes|string',
        'fecha_entrega' => 'sometimes|date',
    ]);

    // Buscar la orden
    $orden = Orden::findOrFail($id);

    // Verificar que el usuario solo pueda actualizar sus propias órdenes
    if ($orden->usuario_id !== $request->user()->id) {
        return response()->json(['error' => 'No tienes permiso para actualizar esta orden'], 403);
    }

    // Actualizar los campos proporcionados
    $orden->update($request->only(['total', 'estado', 'fecha_entrega']));

    return response()->json($orden, 200);
}

public function destroy(Request $request, $id)
{
    // Buscar la orden
    $orden = Orden::findOrFail($id);

    // Verificar que el usuario solo pueda eliminar sus propias órdenes
    if ($orden->usuario_id !== $request->user()->id) {
        return response()->json(['error' => 'No tienes permiso para eliminar esta orden'], 403);
    }

    // Eliminar la orden
    $orden->delete();

    return response()->json(null, 204);
}

public function show(Request $request, $id)
{
    // Buscar la orden
    $orden = Orden::findOrFail($id);

    // Verificar que el usuario solo pueda ver sus propias órdenes
    if ($orden->usuario_id !== $request->user()->id) {
        return response()->json(['error' => 'No tienes permiso para ver esta orden'], 403);
    }

    return response()->json($orden);
}

    public function generarBoleta($id)
    {
        $orden = Orden::findOrFail($id);

        $pdf = Pdf::loadView('boleta', ['orden' => $orden]);
        return $pdf->download('boleta.pdf');
    }
}
