<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';
        
    protected $fillable = ['cliente_id', 'total', 'fecha_compra', 'fecha_creacion', 'fecha_actualizacion'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
