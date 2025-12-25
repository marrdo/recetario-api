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
        Schema::create('supermercados', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('web', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supermercados');
    }
};
