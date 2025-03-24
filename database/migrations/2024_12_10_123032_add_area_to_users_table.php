<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         $table->enum(
    //             'area',
    //             [
    //                 'SGI', // auxiliar de SGI - Resp de SGI
    //                 'HSE', // auxiliar de HSE - Coord HSE 
    //                 'VENTAS', //Auxiliar de Ventas - Coord de ventas
    //                 'LOGISTICA', //Auxiliar de Logistica - Coord de Logistica
    //                 'ALMACEN', //Auxiliar de Almacen  - Coord de Almacen
    //                 'MANTENIMIENTO HTTAS', //Auxiliar de Mantenimiento - Coord de Manto
    //                 'OPERACIONES', //Auxiliar de Operaciones - Coord de Operaciones 
    //                 'RECURSOS HUMANOS', //Auxiliar de RH - Coord de RH
    //                 'TI', //AUXILIAR DE TI - Responsable de TI
    //                 'CONTRATOS Y COBRANZA', //AUX DE CON Y COB- COORD CONTRATOS
    //                 'CONTABILIDAD', //AUX DE CONTABILIDAD -  coor contabilidad
    //                 'COMPRAS E INDIRECTOS', //AUX DE COMPRAS - Resp de compras
    //                 'ADMINISTRACION', //AUX DE ADM - Coord adm
    //                 'MANTENIMIENTO INFRAESTRUCTURA', //RESP DE MANTO INFRA
    //                 'SERVICIOS', //AUX DE SERVICIOS  - Resp de servicios
    //                 'FONDO FIJO' // RESP FONDO JIJO
    //             ]
    //         )->after('departament')->default('TI');;
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         //
    //     });
    // }
};
