<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Ubigeo;
use Illuminate\Http\Request;

class DireccionControlador extends Controller
{
    /**
     * Mostrar todas las direcciones
     */
    public function index()
    {
        // Obtener todas las direcciones
        $direcciones = Direccion::with(['ubigeo', 'cliente'])->get();
        return response()->json($direcciones);
    }

    /**
     * Crear una nueva dirección
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'direccion' => 'required|string',
            'ubigeo_id' => 'nullable|exists:ubigeos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'referencia' => 'nullable|string',
        ]);

        // Crear la dirección
        $direccion = Direccion::create([
            'direccion' => $request->direccion,
            'ubigeo_id' => $request->ubigeo_id,
            'cliente_id' => $request->cliente_id,
            'referencia' => $request->referencia,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Dirección creada con éxito',
            'direccion' => $direccion
        ], 201);
    }

    /**
     * Mostrar una dirección específica
     */
    public function show($id)
    {
        // Buscar la dirección por su ID
        $direccion = Direccion::with(['ubigeo', 'cliente'])->findOrFail($id);

        return response()->json($direccion);
    }

    /**
     * Actualizar una dirección
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'direccion' => 'required|string',
            'ubigeo_id' => 'nullable|exists:ubigeos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'referencia' => 'nullable|string',
        ]);

        // Buscar la dirección
        $direccion = Direccion::findOrFail($id);

        // Actualizar los datos de la dirección
        $direccion->update([
            'direccion' => $request->direccion,
            'ubigeo_id' => $request->ubigeo_id,
            'cliente_id' => $request->cliente_id,
            'referencia' => $request->referencia,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Dirección actualizada con éxito',
            'direccion' => $direccion
        ]);
    }

    /**
     * Eliminar una dirección
     */
    public function destroy($id)
    {
        // Buscar la dirección
        $direccion = Direccion::findOrFail($id);

        // Eliminar la dirección
        $direccion->delete();

        return response()->json(['mensaje' => 'Dirección eliminada con éxito']);
    }

    public function importarCsv(Request $request)
    {
        // Validar que el archivo sea CSV
        $request->validate([
            'archivo' => 'required|mimes:csv,txt|max:2048'
        ]);

        // Abrir el archivo
        $archivo = $request->file('archivo');
        $handle = fopen($archivo->getPathname(), 'r');

        // Omitir la primera línea (encabezado)
        fgetcsv($handle, 1000, ';');

        // Procesar cada línea del CSV
        while (($datos = fgetcsv($handle, 1000, ';')) !== false) {
            Ubigeo::create([
                'ubigeo_reniec'  => $datos[1],
                'departamento'    => $datos[4],
                'provincia'       => $datos[6],
                'distrito'        => $datos[7],
                'fecha_creacion'  => now(),
                'fecha_actualizacion' => now()
            ]);
        }

        fclose($handle);

        return response()->json(['mensaje' => 'Ubigeos importados correctamente'], 201);
    }

    public function direccionesPorCliente($cliente_id)
    {
        // Obtener las direcciones del cliente específico con sus relaciones
        $direcciones = Direccion::where('cliente_id', $cliente_id)
            ->with(['ubigeo', 'cliente'])
            ->get();

        return response()->json($direcciones);
    }
}
