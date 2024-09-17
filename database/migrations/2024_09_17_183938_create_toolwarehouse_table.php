<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('toolwarehouse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('subgroup_id');
            $table->string('description');
            $table->string('serienum');
            $table->string('extdia');
            $table->string('guidia');
            $table->string('insdia');
            $table->string('fishingneck');
            $table->string('conpin');
            $table->string('conbox');
            $table->string('opera');
            $table->decimal('length', 8, 2); // Campo numérico con precisión
            $table->string('necklength');
            $table->string('lastinsp');
            $table->date('datelastinsp');
            $table->string('outfolio');
            $table->date('departuredate');
            $table->unsignedBigInteger('toolstatus_id');
            $table->string('comentary')->nullable();
            $table->string('intloca');
            $table->string('QR')->unique();
            $table->unsignedBigInteger('base_id');

            // Llaves foráneas
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('subgroup_id')->references('id')->on('subgroups')->onDelete('cascade');
            $table->foreign('toolstatus_id')->references('id')->on('toolstatus')->onDelete('cascade');
            $table->foreign('base_id')->references('id')->on('bases')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toolwarehouse');
    }
};
