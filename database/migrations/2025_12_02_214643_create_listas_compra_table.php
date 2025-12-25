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
        Schema::create('listas_compra', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usuario_id');
            $table->uuid('plan_id')->nullable();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['borrador','asociada','comprada'])->default('borrador');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('set null');
            $table->index('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas_compra');
    }
};
