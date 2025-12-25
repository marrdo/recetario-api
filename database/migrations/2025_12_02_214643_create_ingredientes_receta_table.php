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
        Schema::create('ingredientes_receta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('receta_id');
            $table->uuid('alimento_id');
            $table->decimal('cantidad', 10, 2)->default(0)->comment('en unidad_base del alimento');
            $table->decimal('calorias_totales', 10, 2)->default(0);
            $table->decimal('grasas_totales', 10, 2)->default(0);
            $table->decimal('grasas_saturadas', 10, 2)->nullable();
            $table->decimal('hidratos_totales', 10, 2)->default(0);
            $table->decimal('azucares_aniadidos', 10, 2)->nullable();
            $table->decimal('proteinas_totales', 10, 2)->default(0);
            $table->decimal('fibra', 5, 2)->default(0);
            $table->decimal('sodio', 6, 2)->default(0);
            $table->decimal('precio_total', 12, 4)->nullable()->default(0);
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade');

            $table->index('receta_id');
            $table->index('alimento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredientes_receta');
    }
};
