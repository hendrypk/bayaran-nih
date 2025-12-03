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
        Schema::create('performance_kpi_result_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpi_results_id');
            $table->string('aspect')->nullable();
            $table->decimal('target', 10, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('achievement', 10, 2)->nullable();
            $table->decimal('result', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('kpi_results_id')
                  ->references('id')
                  ->on('performance_kpi_results')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_kpi_result_details');
    }
};