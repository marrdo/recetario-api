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
        Schema::create('compras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usuario_id');
            $table->uuid('plan_id')->nullable();
            $table->decimal('total', 12, 4)->default(0);
            $table->enum('estado', ['pendiente','comprado','cancelado'])->default('pendiente');
            $table->timestamp('fecha_compra')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->index('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
