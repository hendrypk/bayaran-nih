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
        Schema::create('employee_pas', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade');

            $table->unsignedBigInteger('pa_id')
                ->references('id')
                ->on('performance_appraisal_name')
                ->onDelete('cascade');

            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes(); 
        });

        // 1. Ambil semua karyawan yang memiliki kpi_id
        $employees = \DB::table('employees')
            ->whereNotNull('pa_id')
            ->select('id', 'pa_id')
            ->get();

        // 2. Masukkan ke tabel baru
        foreach ($employees as $employee) {
            \DB::table('employee_pas')->insert([
                'employee_id' => $employee->id,
                'pa_id'      => $employee->pa_id,
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
        Schema::dropIfExists('employee_pas');
    }
};
