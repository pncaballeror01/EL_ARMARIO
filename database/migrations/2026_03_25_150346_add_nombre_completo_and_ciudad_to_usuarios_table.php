<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable()->after('nombre_usuario');
            $table->string('ciudad')->nullable()->after('nombre_completo');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['nombre_completo', 'ciudad']);
        });
    }
};
