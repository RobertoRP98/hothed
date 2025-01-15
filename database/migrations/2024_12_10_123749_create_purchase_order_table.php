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
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();

            $table->enum('importance_op', ['Alta', 'Media', 'Baja','Critico'])->default('Baja');
            $table->enum('type_op', ['Local', 'Extranjera'])->default('Local');
            $table->date('date_start');
            $table->date('date_end')->nullable();
            $table->enum('status_time', ['Bajo', 'Medio', 'Alto', 'Critico'])->default('Bajo');
            $table->enum('payment_type', ['Credito', 'Debito', 'Efectivo', 'Transferencia'])->default('Credito');
            $table->enum('payment_condition', ['Normal','50-50', '100% Antes Entrega', '100% Post Entrega'])->default('Normal');
            $table->boolean('payment_display')->default(true);

            $table->enum('status_1', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente');
            $table->enum('status_2', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente');
            $table->enum('status_3', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente');
            $table->enum('status_4', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente');
            
            //AÑADIR CAMPO DE COTIZACIÓN
            $table->enum('po_status', ['Iniciada', 'Pendiente de Pago', 'Cancelado', 'Pendiente Comparativa', 'En Transito'])->default('Iniciada');
            $table->enum('bill', ['Facturado', 'Pendiente Facturar'])->default('Pendiente Facturar');
            $table->boolean('finished')->default(false);

            $table->enum('currency', ['MXN', 'USD', 'EUR'])->default('MXN');
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('set null');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
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
