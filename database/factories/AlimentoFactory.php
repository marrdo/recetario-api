<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alimento>
 */
class AlimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->unique()->word(),
            'unidad_base' => 'g',
            'cantidad_base' => 100,
            'calorias_por_base' => $this->faker->numberBetween(50, 500),
            'proteinas_por_base' => $this->faker->numberBetween(0, 30),
            'grasas_por_base' => $this->faker->numberBetween(0, 30),
            'carbohidratos_por_base' => $this->faker->numberBetween(0, 80),
            'notas' => $this->faker->optional()->sentence(),
        ];
    }
}
