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
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('rfc');
                $table->string('number');
                $table->string('email')->nullable();
                $table->string('address');
                $table->boolean('critic')->default(false);
                $table->enum('currency', ['MXN', 'USD', 'MIXTO'])->default('MXN');
                $table->smallInteger('credit_days')->default(0);
                $table->boolean('unique')->default(false);
                $table->string('account')->nullable();
                $table->boolean('contract')->default(false);
                $table->enum('status',['APROVADO','BAJA','CONDICIONADO'])->default('APROVADO');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
