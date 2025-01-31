<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

        // Especifica el nombre de la tabla
        protected $table = 'ordenes';
        
    protected $fillable = ['usuario_id', 'total', 'estado', 'fecha_entrega'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
