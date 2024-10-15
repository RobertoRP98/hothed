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
        Schema::table('companyreceivable', function (Blueprint $table) {
            //
            $table->enum('currency', ['MXN', 'USD'])->default('USD'); // Campo para divisa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companyreceivable', function (Blueprint $table) {
            //
        });
    }
};
