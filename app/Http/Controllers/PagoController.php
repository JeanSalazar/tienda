<?php

namespace App\Http\Controllers;

use App\Mail\CompraRealizada;
use App\Models\Orden;
use Culqi\Culqi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Charge;

class PagoController extends Controller
{
    
    public function pagar(Request $request)
    {
        // Configurar la clave secreta de Culqi
        $culqi = new Culqi([
            'api_key' => env('CULQI_SECRET_KEY')
        ]);
        
        try {
            // Crear un cargo en Culqi
            $charge = $culqi->Charges->create([
                'amount' => $request->monto * 100, // Monto en centavos
                'currency_code' => 'PEN', // Moneda en soles
                'email' => $request->user()->correo, // Correo del usuario
                'source_id' => $request->culqiToken, // Token generado en el frontend
                'description' => 'Compra en Nanotech Store',
            ]);

            // Crear la orden después del pago exitoso
            $orden = Orden::create([
                'usuario_id' => $request->user()->id,
                'total' => $request->monto,
                'fecha_entrega' => now()->addDays(5),
            ]);

            // Enviar correo de confirmación
            Mail::to($request->user()->correo)->send(new CompraRealizada($orden));

            return response()->json(['mensaje' => 'Pago exitoso', 'orden' => $orden], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
