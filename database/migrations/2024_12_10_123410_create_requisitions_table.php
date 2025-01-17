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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status_requisition', ['Pendiente', 'Autorizado', 'Rechazado'])->default('Pendiente');
            $table->enum('importance', ['Alta', 'Media', 'Baja'])->default('Baja');
            $table->boolean('finished')->default(false);
            $table->date('production_date');
            $table->date('request_date');
            $table->integer('days_remaining');
            $table->date('finished_date')->nullable();
            $table->boolean('petty_cash')->default(false);
            $table->text('notes_client')->nullable();
            $table->text('notes_resp')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
