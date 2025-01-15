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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->enum('type', ['Entrada', 'Salida', 'Ajuste'])->default('Entrada');
            $table->integer('quantity');
            $table->text('reason')->nullable(); // Motivo de ajuste o salida.
            $table->unsignedBigInteger('reference_id')->nullable(); // Relación con la OC o Requisición.
            $table->enum('source', ['Orden Compra', 'Requisición', 'Ajuste Manual'])->default('Ajuste Manual');
            $table->timestamps();
        
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
