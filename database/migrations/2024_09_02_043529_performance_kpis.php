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
        // schema::create('performance_kpis', function(Blueprint $table){
        //     $table->id();
        //     $table->string('name');
        //     $table->string('job_title');
        //     $table->integer('target');
        //     $table->integer('bobot');
        //     $table->timestamps();

        //     $table->foreign('job_title')->references('name')->on('job_titles')->onDelete('cascade');

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
