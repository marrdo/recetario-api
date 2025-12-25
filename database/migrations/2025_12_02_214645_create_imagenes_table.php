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
        Schema::create('imagenes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // POLIMORFISMO (Lo mantenemos como 'imageable' por convención de Laravel, 
            // pero te explico cómo usarlo en español en el modelo)
            $table->string('imageable_type'); // Almacena: App\Models\Receta, App\Models\Alimento...
            $table->uuid('imageable_id');   // Almacena el ID del registro relacionado

            // RUTAS DE ARCHIVOS
            $table->string('ruta_desktop');    // Imagen principal / Original optimizada
            $table->string('ruta_mobile')->nullable(); // Versión más ligera para móviles
            $table->string('ruta_thumb')->nullable();  // Miniatura para listados (Thumbnail)

            // METADATOS
            $table->string('alt_text')->nullable(); // Para SEO y accesibilidad (Alt text)
            $table->integer('orden')->default(1);     // Para galerías: 1 es la principal, 2, 3...

            $table->timestamps();
            $table->softDeletes();

            // Índice para que el buscador de imágenes sea veloz
            $table->index(['imageable_type', 'imageable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
