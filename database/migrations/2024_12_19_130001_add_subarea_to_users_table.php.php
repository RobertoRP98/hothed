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
            $table->enum(
                'subarea',
                [
                    'AUXILIAR DE SGI', // auxiliar de SGI - Resp de SGI
                    'RESP. DE SGI', 

                    'AUXILIAR DE HSE',// auxiliar de HSE - Coord HSE 
                    'COORD. DE HSE', 
                     
                    'AUXILIAR DE VENTAS Y OP',
                    'AUXILIAR DE VENTAS',
                    'COORD. DE VENTAS', //Auxiliar de Ventas y OP - Coord de ventas


                    'AUX DE LOGISTICA', //Auxiliar de Logistica - Coord de Logistica
                    'AUX DE LOGISTICA Y MANTO', 
                    'COORD. DE LOGISTICA',

                    'AUXILIAR DE ALMACEN', //Auxiliar de Almacen  - Coord de Almacen
                    'COORD. DE ALMACEN', 

                    'COORD. DE MANTENIMIENTO', //Auxiliar de Mantenimiento - Coord de Manto

                    'OPERATIVOS', //Auxiliar de Operaciones - Coord de Operaciones

                    'COORD. DE RECURSOS HUMANOS', //Auxiliar de RH - Coord de RH
                    'AUXILIAR DE RECURSOS HUMANOS', //Auxiliar de RH - Coord de RH


                    'AUXILIAR DE TI', //AUXILIAR DE TI - Responsable de TI
                    'RESP. DE TI',  


                    'COORD. CONTRATOS', //AUX DE CON Y COB- COORD CONTRATOS
                    'AUX. CONTRATOS',

                    'COORD. CONTABILIDAD', //AUX DE CONTABILIDAD -  coor contabilidad
                    'AUXILIAR DE CONTABILIDAD', //AUX DE CONTABILIDAD -  coor contabilidad

                    'RESP. DE COMPRAS', //AUX DE COMPRAS - Resp de compras
                    'AUX. DE COMPRAS', //AUX DE COMPRAS - Resp de compras

                    'COORD. ADMINISTRATIVO', //AUX DE ADM - Coord adm
                    'AUX. ADMINISTRATIVO', //AUX DE ADM - Coord adm

                    'RESP. MANTENIMIENTO DE INFRAESCTRUCTURA', //RESP DE MANTO INFRA
                    'RESP. DE SERVICIOS', //AUX DE SERVICIOS  - Resp de servicios
                    'RESP. FONDO FIJO', // RESP FONDO JIJO

                    'MCFLY',

                    'ESP. TECNICO',
                    'SUB. GER. OPE',
                    'GER. OPE',
                    'DIR. ADMINISTRACION',
                    'DIR. OPERACIONES',


                ]
            )->after('area')->default('AUXILIAR DE TI');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
