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

        //SECCIONAdo SEGUN LA VISTA
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_id');

            $table->unsignedBigInteger('supplier_id'); 
            $table->enum('type_op', ['Local', 'Extranjera'])->default('Local');
            $table->enum('payment_type', ['CREDITO', 'DEBITO', 'CAJA CHICA', 'TRANSFERENCIA', 'AMEX'])->default('Credito');
            $table->boolean('unique_payment')->default(true); //PAGO EN UNA EXI
            $table->string('quotation')->nullable();
            $table->enum('currency', ['MXN', 'USD', 'EUR'])->default('MXN');

            $table->date('date_start');
            $table->boolean('finished')->default(false);
            $table->date('date_end')->nullable();
            $table->date('payment_day')->nullable();


          

            //$table->enum('status_1', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); //JEFES INMEDIATOS QUE VIENE DE LA REQUISICION
            $table->enum('authorization_2', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); // FLORES Y BIANCA
           // $table->enum('authorization_3', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Autorizado'); // SANTOS ANTES DE IVA - TOMAR SUBTOTAL
            $table->enum('authorization_4', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente'); // LIC KARLA

            
            
            $table->enum('delivery_condition', ['50-50', '100% Antes Entrega', '100% Post Entrega'])->default('100% Antes Entrega');
            $table->enum('po_status', ['PENDIENTE DE PAGO', 'PENDIENTE DE PAGO (SERVICIO CONCLUIDO)', 'PAGADA', 'CANCELADA','EN PAUSA', 'EN PROCESO'])->default('En Proceso');
            $table->enum('bill', ['Facturado', 'Pendiente Facturar'])->default('Pendiente Facturar');
            $table->string('bill_name')->nullable();

            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('total_descuento', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
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
