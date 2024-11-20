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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('eid');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('city');
            $table->string('domicile');
            $table->string('place_birth');
            $table->date('date_birth');
            $table->string('blood_type', 50);
            $table->string('gender', 10);
            $table->string('religion', 15);
            $table->string('marriage', 25);
            $table->string('education', 25);
            $table->string('whatsapp');
            $table->string('bank', 20);
            $table->string('bank_number');
            $table->integer('position_id');
            $table->integer('job_title_id');
            $table->integer('division_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->date('joining_date');
            $table->string('employee_status');
            $table->integer('sales_status');
            $table->integer('kpi_id');
            $table->integer('bobot_kpi');
            $table->string('role')->default('user');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
