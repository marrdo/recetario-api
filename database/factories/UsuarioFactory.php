<?php

namespace Database\Factories;


use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'nickname' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'slug' => Str::slug($this->faker->unique()->userName()),
            'password' => bcrypt('password'),
            'usuario_ip' => $this->faker->ipv4,
            'active' => true,
            'ultimo_login' => now(),
        ];
    }
}
