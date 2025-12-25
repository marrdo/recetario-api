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
        Schema::create('alimento_precios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('alimento_id');
            $table->uuid('supermercado_id');
            $table->uuid('marca_id')->nullable();

            $table->integer('peso_envase')->default(0);
            $table->decimal('precio_envase', 10, 2)->nullable();
            $table->decimal('precio_por_base', 10, 4)->nullable();
            $table->string('descripcion_paquete', 255)->nullable();
            $table->string('codigo_barras', 100)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade');
            $table->foreign('supermercado_id')->references('id')->on('supermercados')->onDelete('cascade');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('set null');

            $table->index(['alimento_id', 'supermercado_id']); // Índice compuesto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimento_precios');
    }
};
