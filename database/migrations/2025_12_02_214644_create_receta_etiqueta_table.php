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
        Schema::create('receta_etiqueta', function (Blueprint $table) {
            $table->uuid('receta_id');
            $table->uuid('etiqueta_id');
            $table->primary(['receta_id', 'etiqueta_id']);
            $table->timestamps();

            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->foreign('etiqueta_id')->references('id')->on('etiquetas')->onDelete('cascade');

            $table->index('receta_id');
            $table->index('etiqueta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_etiqueta');
    }
};
