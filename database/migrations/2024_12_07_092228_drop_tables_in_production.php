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
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('requisitions');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('items_requisition');
        Schema::dropIfExists('order_items_');
        Schema::dropIfExists('products');
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
