<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{

    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    protected $table = 'delivery';

    protected $fillable = ['orden_id', 'direccion_id', 'estado', 'fecha_envio', 'fecha_entrega_estimada', 'fecha_entrega_real', 'fecha_creacion', 'fecha_actualizacion'];

    // Relación con la orden
    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    // Relación uno a uno con Direccion (un delivery tiene una direccion)
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }
}
