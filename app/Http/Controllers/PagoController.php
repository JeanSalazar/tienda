<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Charge;

class PagoController extends Controller
{
    
    public function pagar(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->monto * 100, // Monto en centavos
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Compra en Nanotech Store',
            ]);

            // Crear la orden después del pago exitoso
            $orden = Orden::create([
                'usuario_id' => $request->user()->id,
                'total' => $request->monto,
                'fecha_entrega' => now()->addDays(5),
            ]);

            // Enviar correo
            Mail::to($request->user()->correo)->send(new \App\Mail\CompraRealizada($orden));

            return response()->json(['mensaje' => 'Pago exitoso', 'orden' => $orden], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
