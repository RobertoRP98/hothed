<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
              // Deshabilitar las restricciones de claves foráneas
              DB::statement('SET FOREIGN_KEY_CHECKS=0;');

              // Dropear las tablas
              Schema::dropIfExists('order_items');
              Schema::dropIfExists('items_requisition');
              Schema::dropIfExists('purchase_orders');
              Schema::dropIfExists('requisitions');
              Schema::dropIfExists('suppliers');
              Schema::dropIfExists('products');
              Schema::dropIfExists('taxes');
      
              // Volver a habilitar las restricciones de claves foráneas
              DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production', function (Blueprint $table) {
            //
        });
    }
};
