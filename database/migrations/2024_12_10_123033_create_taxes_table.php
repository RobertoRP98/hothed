<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     //ORDEN DE MIGRACIONES 1.- TAXES 2.- Suppliers 3.-Products
     // 4.- Requisitions 5.-Items requisitions 6.- Purchase order 7.- Items PO
    public function up(): void
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('concept');
            $table->decimal('percentage', 5, 2)->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
