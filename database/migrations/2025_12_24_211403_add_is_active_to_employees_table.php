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
        // 1. Tambahkan kolom is_active jika belum ada
        if (!Schema::hasColumn('employees', 'is_active')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('resignation');
            });
        }

        // 2. Jika resignation ada isinya, maka is_active = false
        // Menggunakan perbandingan string yang lebih aman
        \DB::table('employees')
            ->whereNotNull('resignation')
            ->where('resignation', '<>', '') // Gunakan operator <> 
            ->where('resignation', '<>', '0') // Tambahkan pengecekan string '0' jika ada
            ->update(['is_active' => false]);

        // 3. Pastikan yang tidak memiliki data resign tetap active
        \DB::table('employees')
            ->where(function($query) {
                $query->whereNull('resignation')
                    ->orWhere('resignation', '=', '');
            })
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
