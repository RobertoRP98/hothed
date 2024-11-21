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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->enum('udm', ['Pieza','Kilo', 'Litro', 'Galón', 'Garrafa', 'Servicio']);
            $table->enum('category', ['Consumible','No Consumible', 'Servicio', 'Producto Almacenable']);
            $table->decimal('precio', 10, 2)->default(0.00);

            $table->unsignedBigInteger('taxes_id')->nullable();
            
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->integer('min_stock')->default(0);
            $table->timestamp('update_date_price')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('taxes_id')->references('id')->on('taxes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
