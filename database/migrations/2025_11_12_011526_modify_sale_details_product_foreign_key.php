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
        Schema::table('sale_details', function (Blueprint $table) {
            // Eliminar la foreign key existente
            $table->dropForeign(['product_id']);
            
            // Recrear la foreign key con RESTRICT en lugar de CASCADE
            // Esto previene que se eliminen productos que tengan ventas asociadas
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict'); // RESTRICT previene la eliminación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            // Volver al comportamiento anterior (CASCADE)
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }
};
