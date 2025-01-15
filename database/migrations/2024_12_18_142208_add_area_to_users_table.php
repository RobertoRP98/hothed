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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('area',
            ['SGI', 'HSE', 'VENTAS', 'LOGISTICA', 'ALMACEN', 'MANTENIMIENTO HTTAS','OPERACIONES', 
            'RECURSOS HUMANOS','TI','CONTRATOS Y COBRANZA','CONTABILIDAD','COMPRAS E INDIRECTOS',
            'ADMINISTRACION','MANTENIMIENTO INFRAESTRUCTURA','SERVICIOS','FONDO FIJO']
            )->after('departament');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
