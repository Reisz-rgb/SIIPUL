<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('join_date')->nullable()->after('usia');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('join_date');
            $table->integer('annual_leave_quota')->default(12)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['join_date', 'status', 'annual_leave_quota']);
        });
    }
};