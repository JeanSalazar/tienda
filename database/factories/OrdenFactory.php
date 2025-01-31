<?php

namespace Database\Factories;

use App\Models\Orden;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrdenFactory extends Factory
{
    protected $model = Orden::class;

    public function definition()
    {
        return [
            'usuario_id' => $this->faker->numberBetween(1, 10), // Asegúrate de que existan usuarios
            'total' => $this->faker->randomFloat(2, 50, 1000),
            'estado' => $this->faker->randomElement(['1', '2']),
            'fecha_entrega' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
