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
        Schema::create('employee_kpis', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade');

            $table->unsignedBigInteger('kpi_id')
                ->references('id')
                ->on('performance_kpi_name')
                ->onDelete('cascade');

            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes(); 
        });

        // 1. Ambil semua karyawan yang memiliki kpi_id
        $employees = \DB::table('employees')
            ->whereNotNull('kpi_id')
            ->select('id', 'kpi_id')
            ->get();

        // 2. Masukkan ke tabel baru
        foreach ($employees as $employee) {
            \DB::table('employee_kpis')->insert([
                'employee_id' => $employee->id,
                'kpi_id'      => $employee->kpi_id,
                'is_default'  => true, // Tandai sebagai default karena ini data lama
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_kpis');
    }
};
