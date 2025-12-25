<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre', 50)->unique();
            $table->string('slug', 255)->unique();
            $table->string('color', 7)->nullable()->comment('Código HEX para el frontend, ej: #FF0000');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etiquetas');
    }
};
