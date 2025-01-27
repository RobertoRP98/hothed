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

            $table->enum('type_op', ['Local', 'Extranjera'])->default('Local');
            $table->date('date_start');
            $table->date('payment_day')->nullable();
            $table->date('date_end')->nullable();
           // $table->enum('status_time', ['Bajo', 'Medio', 'Alto', 'Critico'])->default('Bajo'); //NO APLICA PERO LLAMARLO DAYS_PAYMENT Y ES EL CALCULO QUE YA SE TIENE EN LAS REQUIS

            $table->enum('payment_type', ['Credito', 'Debito', 'Efectivo', 'Transferencia'])->default('Credito');
            $table->enum('delivery_condition', ['50-50', '100% Antes Entrega', '100% Post Entrega'])->default('100% Antes Entrega');
            $table->boolean('unique_payment')->default(true); //PAGO EN UNA EXI

            //$table->enum('status_1', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); //JEFES INMEDIATOS QUE VIENE DE LA REQUISICION
            $table->enum('authorization_2', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); // FLORES Y KARLA
            $table->enum('authorization_3', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); // SANTOS ANTES DE IVA - TOMAR SUBTOTAL
            $table->enum('authorization_4', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); // LIC KARLA
            
            $table->string('quotation')->nullable();

            $table->enum('po_status', ['En Proceso', 'Pendiente de Pago', 'Cancelado', 'Pendiente Comparativa', 'En Transito'])->default('En Proceso');
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
