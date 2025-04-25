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
        Schema::create('users_sgi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('employee_number')->unique();
            $table->foreignId('workstation_id')->nullable()->constrained('workstations')->nullOnDelete();
            $table->foreignId('immediate_boss_id')->nullable()->constrained('users_sgi')->nullOnDelete();
            $table->foreignId('area_id')->nullable()->constrained('areas_sgi')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_sgi');
    }
};
