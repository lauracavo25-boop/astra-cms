<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grabaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contenido_id')->constrained('contenidos')->cascadeOnDelete();
            $table->dateTime('fecha');
            $table->string('lugar')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('checklist')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grabaciones');
    }
};
