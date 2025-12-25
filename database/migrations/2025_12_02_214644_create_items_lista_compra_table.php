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
        Schema::create('items_lista_compra', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lista_compra_id');
            $table->uuid('alimento_id');

            $table->uuid('alimento_precio_id')->nullable();
            $table->uuid('supermercado_id')->nullable();

            $table->decimal('cantidad', 10, 2)->default(0);
            $table->enum('unidad', ['g','ml','unidad'])->default('g');

            $table->boolean('comprado')->default(false);

            $table->decimal('precio_unitario', 12, 4)->nullable();
            $table->decimal('precio_total', 12, 4)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lista_compra_id')->references('id')->on('listas_compra')->onDelete('cascade');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade');
            $table->foreign('alimento_precio_id')->references('id')->on('alimento_precios')->onDelete('set null');
            $table->foreign('supermercado_id')->references('id')->on('supermercados')->onDelete('set null');

            $table->index('lista_compra_id');
            $table->index('alimento_id');
            $table->index('alimento_precio_id');
            $table->unique(['lista_compra_id', 'alimento_id', 'unidad']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_lista_compra');
    }
};
