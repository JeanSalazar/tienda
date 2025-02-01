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

    protected $fillable = ['cliente_id', 'total', 'fecha_compra', 'fecha_creacion', 'fecha_actualizacion', 'cupon_id', 'estado', 'importe_igv', 'importe_total', 'importe_venta'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
