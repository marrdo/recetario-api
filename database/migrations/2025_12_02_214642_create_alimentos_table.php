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
        Schema::create('alimentos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('categoria_id')->nullable();
            $table->string('nombre', 255);
            $table->string('slug', 255)->unique();
            $table->enum('unidad_base', ['g','ml','unidad'])->default('g');
            $table->integer('cantidad_base')->default(100);
            $table->decimal('calorias_por_base', 8, 2)->default(0);
            $table->decimal('proteinas_por_base', 8, 2)->default(0);
            $table->decimal('grasas_por_base', 8, 2)->default(0);
            $table->decimal('carbohidratos_por_base', 8, 2)->default(0);
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias_alimentos')
                ->onDelete('set null');

            $table->index(['nombre', 'slug', 'categoria_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
