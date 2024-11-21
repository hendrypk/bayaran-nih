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
        // Create `performance_appraisals` table
        Schema::create('performance_appraisals', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `performance_kpis` table
        Schema::create('performance_kpis', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->integer('kpi_id');
            $table->string('aspect');
            $table->decimal('target', 25,2);
            $table->decimal('bobot', 5,2);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `performance_kpi_name` table
        Schema::create('performance_kpi_name', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `grade_kpis` table
        Schema::create('grade_kpis', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->integer('employee_id');
            $table->integer('indicator_id');
            $table->decimal('achievement', 25,2);
            $table->integer('grade');
            $table->string('month');
            $table->integer('year');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `grade_pas` table
        Schema::create('grade_pas', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->integer('employee_id');
            $table->integer('appraisal_id');
            $table->string('month');
            $table->integer('year');
            $table->integer('grade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop `performance_kpi_name` table
        Schema::dropIfExists('performance_kpi_name');

        // Drop `performance_kpis` table
        Schema::dropIfExists('performance_kpis');

        // Drop `performance_appraisals` table
        Schema::dropIfExists('performance_appraisals');

        // Drop `grade_pas` table
        Schema::dropIfExists('grade_pas');

        // Drop `grade_kpis` table
        Schema::dropIfExists('grade_kpis');
    }
};
