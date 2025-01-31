<?php

namespace Database\Seeders;

use App\Models\Orden;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crear 20 órdenes falsas

       Usuario::all()->each(function ($usuario) {
        Orden::factory()->create([
            'usuario_id' => $usuario->id,
            'total' => 930.79,
            'estado' => '2',
            'fecha_entrega' => now()->addDays(15),
        ]);
    });
    
    }
}
