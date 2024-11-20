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
        // Create `divisions` table
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft delete
        });

        // Create `departments` table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft delete
        });

        // Create `employee_status` table
        Schema::create('employee_status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `holidays` table
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `job_titles` table
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->integer('section');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `positions` table
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create `office_locations` table
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('radius');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order
        Schema::dropIfExists('office_locations');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('job_titles');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('employee_status');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('divisions');
    }
};
