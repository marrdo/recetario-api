<?php

namespace Database\Seeders;

use App\Models\Alimento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Alimento::factory()->count(50)->create();
    }
}
