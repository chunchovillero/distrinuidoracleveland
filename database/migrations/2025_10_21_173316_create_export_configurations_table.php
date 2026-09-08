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
        Schema::create('export_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('export_type'); // 'despacho' o 'secretaria'
            $table->json('selected_fields'); // Campos seleccionados
            $table->boolean('is_default')->default(false); // Si es la configuración por defecto
            $table->timestamps();
            
            $table->unique(['export_type', 'is_default']); // Solo una configuración por defecto por tipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_configurations');
    }
};
