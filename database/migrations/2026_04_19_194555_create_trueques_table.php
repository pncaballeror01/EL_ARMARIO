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
        Schema::create('trueques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emisor_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreignId('receptor_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreignId('camiseta_oferta_id')->constrained('camisetas')->onDelete('cascade');
            $table->foreignId('camiseta_objetivo_id')->constrained('camisetas')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trueques');
    }
};
