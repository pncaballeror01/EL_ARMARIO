<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camisetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->string('equipo');
            $table->string('talla');
            $table->string('año');
            $table->string('estado');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camisetas');
    }
};
