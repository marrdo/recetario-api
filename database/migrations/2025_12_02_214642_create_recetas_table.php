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
        Schema::create('recetas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // 1. Identidad y Autoría
            $table->uuid('usuario_id')->nullable()->comment('FK al usuario creador. Null si es receta del sistema.');
            $table->string('titulo', 255);
            $table->string('slug', 255)->unique();

            // 2. Metadata
            $table->string('external_url', 255)->nullable();

            // 3. Valores Nutricionales (Cálculos Derivados)
            $table->decimal('calorias_totales', 10, 2)->default(0);
            $table->decimal('grasas_totales', 10, 2)->default(0);
            $table->decimal('hidratos_totales', 10, 2)->default(0);
            $table->decimal('proteinas_totales', 10, 2)->default(0);
            $table->decimal('fibra', 5, 2)->default(0);
            $table->decimal('azucar', 5, 2)->default(0);
            $table->decimal('sodio', 6, 2)->default(0);

            // 4. Desarrollo de la receta
            $table->text('descripcion')->nullable();
            $table->longText('instrucciones')->nullable();
            $table->integer('tiempo_preparacion')->default(0)->comment('segundos');
            $table->integer('tiempo_coccion')->nullable()->comment('segundos');
            $table->integer('porciones')->default(1);
            $table->enum('dificultad', ['facil','media','dificil'])->default('media');
            $table->integer('personas')->default(1);
            
            // 5. Gestión y Fechas
            $table->boolean('verificado')->default(false); 
            $table->timestamps();
            $table->softDeletes(); // Para borrado suave

            // Foreign Key e Índices
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null');
            $table->index('usuario_id');
            // Añadir índice al título si se busca mucho por él
            $table->index('titulo'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
