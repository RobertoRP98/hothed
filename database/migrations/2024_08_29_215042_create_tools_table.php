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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->unique();
            $table->string('od');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('return_day');
            $table->time('return_time');
            $table->foreignId('well_oil_id')->constrained('wells_oil');
            $table->integer('days_use');
            $table->decimal('cost_day');
            $table->decimal('cost_standby');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('condition_id')->constrained('conditions');
            $table->foreignId('status_id')->constrained('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
