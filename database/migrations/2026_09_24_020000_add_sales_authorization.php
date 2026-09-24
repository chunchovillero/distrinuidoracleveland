<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('created_by_user_id')->nullable()->after('seller_id')
                ->constrained('users')->nullOnDelete();
        });

        DB::statement("ALTER TABLE sales MODIFY status ENUM('pending_authorization', 'pending', 'completed', 'cancelled') NOT NULL DEFAULT 'completed'");
    }

    public function down(): void
    {
        DB::table('sales')->where('status', 'pending_authorization')->update(['status' => 'pending']);
        DB::statement("ALTER TABLE sales MODIFY status ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'completed'");
        Schema::table('sales', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by_user_id');
        });
    }
};
