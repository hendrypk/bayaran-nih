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
        Schema::table('employees', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('resignation');
        });

        // Jika resignation ada isinya (NOT NULL), maka is_active = false (0)
        \DB::table('employees')
            ->whereNotNull('resignation')
            ->where('resignation', '!=', '')
            ->update(['is_active' => false]);
            
        // Jika resignation kosong (NULL atau string kosong), pastikan tetap true (1)
        \DB::table('employees')
            ->whereNull('resignation')
            ->orWhere('resignation', '')
            ->update(['is_active' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
