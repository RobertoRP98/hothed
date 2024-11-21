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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_id');
            $table->unsignedBigInteger('supplier_id');
            $table->enum('type_po', ['Local', 'Extranjera']);
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->enum('status_time', ['Alto', 'Medio', 'Bajo'])->default('Bajo');
            $table->enum('status_manager1', ['Autorizado', 'Cancelado'])->default('Autorizado');
            $table->enum('status_manager2', ['Autorizado', 'Cancelado'])->default('Autorizado');
            $table->enum('status_manager3', ['Autorizado', 'Cancelado'])->default('Autorizado');
            $table->enum('status_manager4', ['Autorizado', 'Cancelado'])->default('Autorizado');
            $table->enum('po_importance', ['Alto', 'Medio', 'Bajo'])->default('Bajo');
            $table->enum('currency', ['USD', 'MXN']);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->unsignedBigInteger('taxes_id')->nullable();
            $table->enum('po_status', ['Pagado', 'Aduana', 'En espera de entrega', 'Otro'])->default('En espera de entrega');
            $table->enum('bill', ['Sin generar', 'Pendiente', 'Generada', 'Cancelada'])->default('Sin generar');
            $table->boolean('finalizado')->default(false);
            $table->timestamps();
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('taxes_id')->references('id')->on('taxes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
