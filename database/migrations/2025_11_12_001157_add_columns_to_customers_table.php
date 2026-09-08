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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('rut', 20)->nullable()->after('name');
            $table->string('celular', 20)->nullable()->after('phone');
            $table->string('direccion')->nullable()->after('address');
            $table->string('localidad')->nullable()->after('direccion');
            $table->string('transporte')->nullable()->after('localidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['rut', 'celular', 'direccion', 'localidad', 'transporte']);
        });
    }
};
