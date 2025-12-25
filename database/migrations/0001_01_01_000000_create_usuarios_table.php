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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Datos Identificativos
            $table->string('nickname', 255); // Campo que hará referencia al nombre del usuario que será visible en la web, si no sale nada serán su nombre y apellidos.
            $table->string('nombre', 255);
            $table->string('apellidos' ,255)->nullable();
            $table->string('email', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('password');
            $table->string('telefono', 50)->nullable();

            // Config y Estado
            $table->boolean('active')->default(true);
            $table->text('notas')->nullable();
            $table->string('lang', 5)->nullable(); // 'es', 'en', etc

            // Seguridad
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Datos Físicos y Nutricionales
            $table->date('fecha_nacimiento')->nullable(); // Se usa para calcular requerimientos calóricos.
            $table->enum('genero', ['hombre', 'mujer', '-'])->default('hombre')->nullable(); // Necesario para las fórmulas de Tasa Metabólica Basal (Harris-Benedict, Mifflin-St Jeor).
            $table->integer('altura')->nullable(); // Altura en cm
            $table->decimal('peso_actual', 5, 2)->nullable(); // 5 dígitos total, 2 decimales (ej: 120.50)
            $table->decimal('peso_objetivo', 5, 2)->nullable(); // Peso objetivo (para saber si debe haber déficit o superávit calórico).
            $table->enum('nivel_actividad', ['sedentario', 'ligero', 'moderado', 'intenso'])->nullable();

            // Auditoría
            $table->ipAddress('usuario_ip')->nullable();
            $table->macAddress('usuario_mac')->nullable();
            $table->timestamp('ultimo_login')->nullable(); // Saber cual es la última vez que entró el usuario.

            $table->timestamps();
            
            $table->index('email');
            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
