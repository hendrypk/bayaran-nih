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
        Schema::create('performance_appraisal_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_created');
            $table->unsignedBigInteger('user_updated');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('pa_id');
            $table->string('month');
            $table->integer('year');
            $table->decimal('grade', 5, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('pa_id')->references('id')->on('performance_appraisal_name')->onDelete('cascade');
            $table->foreign('user_created')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('user_updated')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_appraisal_results');
    }
};
