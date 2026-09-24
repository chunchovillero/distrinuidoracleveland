<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatch_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('requires_address')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('dispatch_type_id')->nullable()->after('payment_method')
                ->constrained('dispatch_types')->restrictOnDelete();
            $table->string('dispatch_address')->nullable()->after('dispatch_type_id');
        });

        DB::table('dispatch_types')->insert([
            ['name' => 'Camión', 'requires_address' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Starken', 'requires_address' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Retiro en tienda', 'requires_address' => false, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dispatch_type_id');
            $table->dropColumn('dispatch_address');
        });

        Schema::dropIfExists('dispatch_types');
    }
};
