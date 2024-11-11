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
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('bill_number');
            $table->date('bill_date');
            $table->date('entry_date');
            $table->date('expiration_date');
            $table->string('description');
            $table->string('oil_well');
            $table->date('start_operation');
            $table->date('end_operation');
            $table->decimal('total_payment',15,2);
            $table->enum('status',['pendiente_facturar','pendiente_cobrar','pagado','aclaración','cancelado','pendiente_entrada'])->default('pendiente_facturar');
            $table->date('billing_date')->nullable();
            $table->date('payment_day')->nullable();
            $table->string('comentary')->nullable();
            $table->boolean('porcent')->after('comentary');
            $table->foreignId('companyreceivable_id')->constrained('companyreceivable')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill');
    }
};
