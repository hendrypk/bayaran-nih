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
            $table->decimal('target', 10, 2)->change(); // 8 digits total, 2 after the decimal
            $table->decimal('bobot', 5, 2)->change();  // 5 digits total, 2 after the decimal
        });

        Schema::table('grade_kpis', function (Blueprint $table) {
            $table->decimal('achievement', 10, 2)->change();
            $table->decimal('grade', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
