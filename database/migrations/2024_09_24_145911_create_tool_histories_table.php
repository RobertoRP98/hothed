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
        Schema::create('tool_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toolwarehouse_id');
            $table->unsignedBigInteger('user_id');
            $table->string('field');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();


            //Llaves foraneas
            $table->foreign('toolwarehouse_id')->references('id')->on('toolwarehouse')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_histories');
    }
};
