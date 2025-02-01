<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'ordenes';

    protected $fillable = ['cliente_id', 'fecha_compra', 'fecha_creacion', 'fecha_actualizacion', 'cupon_id', 'estado', 'importe_preliminar', 'importe_igv', 'importe_total', 'importe_venta'];


    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Cupón
    public function cupon()
    {
        return $this->belongsTo(Cupon::class);
    }

    // Relación con los Productos en la Orden
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'orden_productos')
            ->withPivot('cantidad', 'precio_unitario');
    }

    // Aplicar Cupón y calcular el descuento
    public function calcularTotal()
    {
        $subtotal = $this->productos->sum(function ($producto) {
            return $producto->pivot->cantidad * $producto->pivot->precio_unitario;
        });

        if ($this->cupon) {
            if ($this->cupon->tipo_descuento == 1) { // Descuento en porcentaje
                $descuento = ($subtotal * $this->cupon->valor_descuento) / 100;
            } else { // Descuento fijo
                $descuento = $this->cupon->valor_descuento;
            }
            $subtotal -= min($subtotal, $descuento);
        }

        return $subtotal;
    }
}
