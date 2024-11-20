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
        // Schema::create('grade_pa', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('eid');
        //     $table->unsignedTinyInteger('month');
        //     $table->unsignedSmallInteger('year');
        //     $table->unsignedBigInteger('appraisal_id');
        //     $table->integer('grade');
        //     $table->timestamps();

        //     $table->foreign('appraisal_id')->references('id')->on('performance_appraisal')->onDelete('cascade');
        //     $table->foreign('eid')->references('id')->on('employees')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
