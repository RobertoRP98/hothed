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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('version');
            $table->foreignId('category_id')->nullable()->constrained('documents_categories')->nullOnDelete();
            $table->boolean('download')->default(false);
            $table->boolean('general')->default(false);
            $table->string('file_path_pdf')->nullable(); // antes "root"
            $table->string('file_path_doc')->nullable(); // antes "root"
            $table->foreignId('revisor_id')->nullable()->constrained('users_sgi')->nullOnDelete();
            $table->foreignId('aprobador_id')->nullable()->constrained('users_sgi')->nullOnDelete();
            $table->foreignId('area_resp_id')->nullable()->constrained('areas_sgi')->nullOnDelete();
            $table->enum('auth_1', ['PENDIENTE', 'AUTORIZADO', 'RECHAZADO'])->default('PENDIENTE'); // REVISOR
            $table->enum('auth_2', ['PENDIENTE', 'AUTORIZADO', 'RECHAZADO'])->default('PENDIENTE'); // AUTORIZADOR
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
