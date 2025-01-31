<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;

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

    public function generarBoleta($id)
    {
        $orden = Orden::findOrFail($id);

        $pdf = Pdf::loadView('boleta', ['orden' => $orden]);
        return $pdf->download('boleta.pdf');
    }
}
