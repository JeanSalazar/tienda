<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;
use Carbon\Carbon;

class CuponControlador extends Controller
{
    // Obtener todos los cupones
    public function index()
    {
        return response()->json(Cupon::all());
    }

    // Crear un nuevo cupón
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:cupones',
            'descripcion' => 'required|string',
            'tipo_descuento' => 'required|in:1,2',
            'valor_descuento' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'usos_maximo' => 'required|integer|min:0',
        ]);

        $cupon = Cupon::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'tipo_descuento' => $request->tipo_descuento,
            'valor_descuento' => $request->valor_descuento,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'usos_maximo' => $request->usos_maximo,
            'usos_actuales' => 0,
            'fecha_creacion' => Carbon::now(),
            'fecha_actualizacion' => Carbon::now(),
        ]);

        return response()->json($cupon, 201);
    }

    // Mostrar un cupón por su ID
    public function show($id)
    {
        $cupon = Cupon::find($id);

        if (!$cupon) {
            return response()->json(['message' => 'Cupón no encontrado'], 404);
        }

        return response()->json($cupon);
    }

    // Actualizar un cupón
    public function update(Request $request, $id)
    {
        $cupon = Cupon::find($id);

        if (!$cupon) {
            return response()->json(['message' => 'Cupón no encontrado'], 404);
        }

        $request->validate([
            'descripcion' => 'string',
            'tipo_descuento' => 'in:1,2',
            'valor_descuento' => 'numeric|min:0',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date|after_or_equal:fecha_inicio',
            'usos_maximo' => 'integer|min:0',
        ]);

        $cupon->update($request->all());
        $cupon->fecha_actualizacion = Carbon::now();
        $cupon->save();

        return response()->json($cupon);
    }

    // Eliminar un cupón
    public function destroy($id)
    {
        $cupon = Cupon::find($id);

        if (!$cupon) {
            return response()->json(['message' => 'Cupón no encontrado'], 404);
        }

        $cupon->delete();
        return response()->json(['message' => 'Cupón eliminado correctamente']);
    }
}
