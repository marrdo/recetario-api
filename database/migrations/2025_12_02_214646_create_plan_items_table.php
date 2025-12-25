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
        Schema::create('plan_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('plan_id');

            $table->date('fecha');
            $table->enum('momento_dia', [
                'desayuno',
                'media_manana',
                'comida',
                'merienda',
                'media_tarde',
                'cena'
            ]);

            $table->uuid('receta_id')->nullable();
            $table->uuid('alimento_id')->nullable();

            $table->decimal('cantidad', 10, 2)->nullable();
            $table->enum('unidad', ['g','ml','unidad'])->nullable();

            $table->decimal('calorias_totales', 10, 2)->nullable();
            $table->integer('orden')->default(1);

            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('set null');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('set null');

            $table->index('plan_id');
            $table->unique(['plan_id', 'fecha', 'momento_dia', 'orden']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_items');
    }
};
