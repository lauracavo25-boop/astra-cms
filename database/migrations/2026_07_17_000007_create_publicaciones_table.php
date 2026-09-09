<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formato_id')->constrained('formatos')->cascadeOnDelete();
            $table->string('plataforma');
            $table->dateTime('fecha_programada')->nullable();
            $table->dateTime('fecha_publicada')->nullable();
            $table->string('url_publicada')->nullable();
            $table->text('metricas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
