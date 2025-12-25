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
        Schema::create('compra_lista_compra', function (Blueprint $table) {
            
            $table->uuid('compra_id');
            $table->uuid('lista_compra_id');
            $table->primary(['compra_id','lista_compra_id']);
            $table->timestamps();

            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            $table->foreign('lista_compra_id')->references('id')->on('listas_compra')->onDelete('cascade');

            $table->index('compra_id');
            $table->index('lista_compra_id');
            $table->unique(['compra_id', 'lista_compra_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_lista_compra');
    }
};
