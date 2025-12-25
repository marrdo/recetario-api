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
        Schema::create('planes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usuario_id')->nullable();
            $table->string('nombre', 255);
            $table->string('slug', 255)->unique();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('calorias_objetivo_diario')->nullable();
            $table->enum('estado', ['borrador','activo','finalizado'])->default('borrador');
            $table->text('descripcion')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null');
            $table->index('usuario_id');
            $table->index('nombre');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
