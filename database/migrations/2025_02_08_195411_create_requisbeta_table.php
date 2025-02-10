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
        Schema::create('requisbeta', function (Blueprint $table) {
            $table->id();
            $table->enum('dep_soli', ['ADMINISTRACION', 'OPERACIONES', 'SGI'])->nullable();
            $table->string('requisicion')->nullable();
            $table->date('fecha_requi')->nullable();
            $table->enum('prioridad', ['ALTA', 'MEDIA', 'BAJA'])->nullable();
            $table->string('comentario')->nullable()->default('NA');
            $table->enum('orden_compra', ['COTIZANDO', 'CREADA(S)'])->nullable();
            $table->date('fecha_coti')->nullable();
            $table->enum('status_oc', ['PENDIENTE PAGO', 'PAGADA', 'CANCELADA', 'EN PAUSA', 'VENCIDA'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisbeta');
    }
};
