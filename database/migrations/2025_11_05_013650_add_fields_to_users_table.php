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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email'); // admin, manager, seller, user
            $table->boolean('active')->default(true)->after('role');
            $table->string('phone')->nullable()->after('active');
            $table->text('address')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('address');
            $table->timestamp('last_login_at')->nullable()->after('avatar');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'active', 
                'phone',
                'address',
                'avatar',
                'last_login_at',
                'last_login_ip'
            ]);
        });
    }
};
