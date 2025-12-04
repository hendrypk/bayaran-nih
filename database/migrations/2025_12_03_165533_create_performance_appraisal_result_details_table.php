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
        Schema::create('performance_appraisal_result_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appraisal_result_id');
            $table->string('aspect')->nullable();
            $table->string('description')->nullable();
            $table->decimal('achievement', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('appraisal_result_id')
                  ->references('id')
                  ->on('performance_appraisal_results')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_appraisal_result_details');
    }
};
