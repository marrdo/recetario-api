<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Alimento;
// use App\Models\*; Esto se podrá hacer para que coja todos los modelos?
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RolesSeeder::class,
            UsuarioSeeder::class,
            AlimentoSeeder::class
        ]);
        
        Usuario::factory()->count(50)->create();
    }
}
