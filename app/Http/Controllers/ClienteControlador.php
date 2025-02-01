<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ClienteControlador extends Controller
{
    /**
     * Mostrar todos los clientes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * Crear un nuevo cliente.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nro_documento' => 'required|string|max:11|unique:clientes,nro_documento',
            'celular' => 'nullable|string|max:9',
        ]);

        // Crear el cliente
        $cliente = Cliente::create([
            'usuario_id' => $request->usuario_id,
            'nro_documento' => $request->nro_documento,
            'celular' => $request->celular,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Cliente creado con éxito',
            'cliente' => $cliente
        ], 201);
    }

    /**
     * Mostrar un cliente específico por ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente);
    }

    /**
     * Actualizar un cliente existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nro_documento' => 'required|string|max:11|unique:clientes,nro_documento,' . $id,
            'celular' => 'nullable|string|max:9',
        ]);

        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        // Actualizar el cliente
        $cliente->update([
            'usuario_id' => $request->usuario_id,
            'nro_documento' => $request->nro_documento,
            'celular' => $request->celular,
            'fecha_actualizacion' => now(),
        ]);

        return response()->json([
            'mensaje' => 'Cliente actualizado con éxito',
            'cliente' => $cliente
        ]);
    }

    /**
     * Eliminar un cliente.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
        }

        // Eliminar el cliente
        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado con éxito']);
    }
}
