<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->decimal('commission_unit_price', 10, 2)->default(0)->after('unit_price');
        });

        // Conserva el valor histórico disponible; las nuevas ventas usan el monto fijo.
        DB::table('sale_details')->update([
            'commission_unit_price' => DB::raw('commission_percentage'),
        ]);
    }

    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn('commission_unit_price');
        });
    }
};
