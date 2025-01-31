<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'precio_base' => $this->faker->randomFloat(2, 10, 1000),
            'igv' => 0.18,
            'precio_final' => function (array $attributes) {
                return $attributes['precio_base'] * 1.18;
            },
            'stock' => $this->faker->numberBetween(1, 100),
            'categoria_id' => $this->faker->numberBetween(1, 5), // Asegúrate de que existan categorías
        ];
    }
}
