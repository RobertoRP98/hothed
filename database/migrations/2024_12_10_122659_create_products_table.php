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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('internal_id')->unique();
            $table->text('description');
            $table->string('brand')->nullable();
            $table->integer('quantity')->default(0);

            $table->enum('udm', ['PIEZAS', 'KG', 'LITROS', 'SERVICIO','KILOMETROS','METROS CUBICOS','METROS CUADRADOS', 
            'METROS', 'LIBRAS', 'GALONES', 'CUBETAS', 'TAMBORES', 'JUEGOS', 'HORAS', 'DIAS'])->default('PIEZAS');


            $table->enum('category', ['ACCESORIO', 'CONSUMIBLE', 'EMPAQUES', 'EPP',
            'HERRAMIENTA','REFACCION', 'TORQUE','SERVICIO'])->default('CONSUMIBLE');
            
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->text('commentary')->nullable();
            $table->timestamps();

            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
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
