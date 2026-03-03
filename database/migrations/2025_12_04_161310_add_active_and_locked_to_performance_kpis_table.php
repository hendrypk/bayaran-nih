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
        Schema::table('performance_kpis', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('weight');
            $table->boolean('locked')->default(false)->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_kpis', function (Blueprint $table) {
            $table->dropColumn(['active', 'locked']);
        });
    }
};
