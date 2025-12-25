<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    // use WithoutModelEvents; // Esto ignora el Observer solo durante este Seeder
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $usuario = Usuario::create([
            'nombre' => 'Admin',
            'nickname' => 'admin',
            'slug' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'usuario_ip' => '192.168.1.1',
            'lang' => 'es',
            'active' => true,
        ]);

        $usuario->roles()->attach(
            \App\Models\Rol::where('nombre', 'admin')->first()->id
        );
    }
}
