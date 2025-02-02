<?php


namespace App\Http\Controllers;

use App\Mail\CompraPendiente;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cupon;
use App\Models\Delivery;
use App\Models\OrdenProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use Culqi\Culqi;

class OrdenControlador extends Controller
{
    // Listar todas las órdenes
    public function index()
    {
        return response()->json(Orden::with('cliente', 'productos', 'cupon')->get());
    }

    // Listar órdenes por cliente
    public function ordenesPorCliente($cliente_id)
    {
        $ordenes = Orden::where('cliente_id', $cliente_id)->with('productos', 'cupon')->get();
        return response()->json($ordenes);
    }
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'cupon_id' => 'nullable|exists:cupones,id',
            'productos' => 'required|array', // Array con productos y cantidades
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $importe_preliminar = 0;

        foreach ($request->productos as $producto) {
            $prod = Producto::find($producto['id']);
            $importe_preliminar += $prod->precio * $producto['cantidad'];
        }

        // Aplicar cupón si existe
        $importe_descuento = 0;
        if ($request->cupon_id) {
            $cupon = Cupon::find($request->cupon_id);
            if ($cupon->tipo_descuento == 1) { // Porcentaje
                $importe_descuento = ($importe_preliminar * $cupon->valor_descuento) / 100;
            } else { // Descuento fijo
                $importe_descuento = $cupon->valor_descuento;
            }
        }

        $importe_venta = max($importe_preliminar - $importe_descuento, 0);
        $importe_igv = $importe_venta * 0.18;
        $importe_total = $importe_venta + $importe_igv;

        $orden = Orden::create([
            'cliente_id' => $request->cliente_id,
            'cupon_id' => $request->cupon_id,
            'fecha_compra' => now(),
            'importe_preliminar' => $importe_preliminar,
            'importe_total' => $importe_total,
            'importe_venta' => $importe_venta,
            'importe_descuento' => $importe_descuento,
            'importe_igv' => $importe_igv,
            'estado' => 1, // Pendiente de pago
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);

        // Guardar los productos en ordenes_productos
        foreach ($request->productos as $producto) {
            OrdenProducto::create([
                'orden_id' => $orden->id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ]);
        }

        // Crear un delivery relacionado con la orden
        $delivery = Delivery::create([
            'orden_id' => $orden->id,
            'direccion_id' => $request->direccion_id,
            'estado' => 1, // 1: Enviado
            'fecha_envio' => Carbon::now(), // Fecha de envío (hoy)
            'fecha_entrega_estimada' => Carbon::now()->addDays(7), // Fecha estimada de entrega (1 día después)
            'fecha_creacion' => Carbon::now(),
            'fecha_actualizacion' => Carbon::now(),
        ]);


        // Enviar correo electrónico
        Mail::to($orden->cliente->usuario->correo)->send(new CompraPendiente($orden));

        return response()->json($orden->load('productos'), 201);
    }

    public function update(Request $request, $id)
    {
        $orden = Orden::findOrFail($id);

        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'cupon_id' => 'nullable|exists:cupones,id',
            'productos' => 'nullable|array',
            'productos.*.id' => 'exists:productos,id',
            'productos.*.cantidad' => 'integer|min:1',
            'estado' => 'nullable|in:1,2,3'
        ]);

        if ($request->has('productos')) {
            $importe_preliminar = 0;

            // Eliminar productos anteriores de la orden
            OrdenProducto::where('orden_id', $orden->id)->delete();

            foreach ($request->productos as $producto) {
                $prod = Producto::find($producto['id']);
                $importe_preliminar += $prod->precio * $producto['cantidad'];

                OrdenProducto::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                    'fecha_creacion' => now(),
                    'fecha_actualizacion' => now(),
                ]);
            }

            $importe_descuento = 0;
            if ($request->cupon_id) {
                $cupon = Cupon::find($request->cupon_id);
                if ($cupon->tipo_descuento == 1) {
                    $importe_descuento = ($importe_preliminar * $cupon->valor_descuento) / 100;
                } else {
                    $importe_descuento = $cupon->valor_descuento;
                }
            }

            $importe_venta = max($importe_preliminar - $importe_descuento, 0);
            $importe_igv = $importe_venta * 0.18;
            $importe_total = $importe_venta + $importe_igv;

            $orden->update([
                'importe_preliminar' => $importe_preliminar,
                'importe_total' => $importe_total,
                'importe_venta' => $importe_venta,
                'importe_descuento' => $importe_descuento,
                'importe_igv' => $importe_igv,
                'fecha_actualizacion' => now(),
            ]);
        }

        if ($request->has('estado')) {
            $orden->update(['estado' => $request->estado]);
        }


        // Enviar correo electrónico
        Mail::to($orden->cliente->usuario->correo)->send(new CompraPendiente($orden));

        return response()->json($orden->load('productos'));
    }



    // Mostrar una orden específica
    public function show($id)
    {
        $orden = Orden::with('cliente', 'productos', 'cupon')->find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        return response()->json($orden);
    }

    // Eliminar una orden
    public function destroy($id)
    {
        $orden = Orden::find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        OrdenProducto::where('orden_id', $orden->id)->delete();
        $orden->delete();

        return response()->json(['message' => 'Orden eliminada correctamente']);
    }


    public function generarBoleta($orden_id)
    {
        $orden = Orden::with('cliente', 'productos', 'cupon')->find($orden_id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $pdf = \PDF::loadView('boleta', compact('orden')); // Cargar la vista con los datos de la orden
        return $pdf->download("boleta_{$orden->id}.pdf");
    }



    // Pagar con Culqi
    public function pagarConCulqi(Request $request, $orden_id)
    {
        // Buscar la orden
        $orden = Orden::find($orden_id);

        // Verificar si la orden existe
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        // Validar que el token esté presente en la solicitud
        $request->validate([
            'token' => 'required|string',
        ]);

        // Inicializar Culqi con la clave secreta desde el archivo .env
        $culqi = new \Culqi\Culqi(['api_key' => env('CULQI_SECRET_KEY')]);

        try {
            // Crear el cargo en Culqi
            $cargo = $culqi->Charges->create([
                //"amount" => $orden->total * 100,  // El monto en céntimos
                "amount" => 100,
                "currency_code" => "PEN",  // Moneda
                "email" => $orden->cliente->usuario->correo,  // Correo electrónico del cliente
                "source_id" => $request->token,  // El token de la tarjeta
            ]);
            dd($cargo);
            // Verificar si el cargo fue exitoso
            if ($cargo->status == 'approved') {
                // Marcar la orden como pagada
                $orden->estado = 2;  // Estado 2 podría representar "Pagado"
                $orden->fecha_actualizacion = Carbon::now();
                $orden->save();

                // Opcional: Enviar un correo de confirmación de pago o cualquier otra acción

                return response()->json([
                    'message' => 'Pago realizado con éxito',
                    'cargo' => $cargo
                ], 200);
            } else {
                // Si el pago no es aprobado, mostrar el estado
                return response()->json([
                    'message' => 'El pago no fue aprobado',
                    'cargo' => $cargo
                ], 400);
            }
        } catch (\Culqi\Exceptions\ApiErrorException $e) {
            // Capturar errores específicos de la API de Culqi
            return response()->json([
                'message' => 'Error al procesar el pago con Culqi',
                'error' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            // Capturar cualquier otro error
            return response()->json([
                'message' => 'Error en el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
