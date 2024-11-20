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
        // schema::create('payroll_options', function(Blueprint $table){
        //     $table->id();
        //     $table->string('eid')->unique();
        //     $table->string('name');
        //     $table->integer('basic');
        //     $table->integer('health');
        //     $table->integer('meal');
        //     $table->integer('dicipline');
        //     $table->integer('performance');
        //     $table->integer('comission');
        //     $table->integer('overtime');
        //     $table->integer('uang_pisah');
        //     $table->integer('leave_cahsed');
        //     $table->integer('absence');
        //     $table->integer('lateness');
        //     $table->integer('meal_deduction');
        //     $table->integer('dicipline_deduction');
        //     $table->integer('check_out_early');
        //     $table->integer('penalty');
        //     $table->integer('comission_deduction');
        //     $table->integer('loan');
        //     $table->integer('sallary_adjustment');
        //     $table->integer('kpi_percent');
        //     $table->integer(('pa_percent'));
        //     $table->timestamps();

        //     $table->foreign('eid')->references('eid')->on('employees')->onDelete('cascade');
        //     $table->foreign('name')->references('name')->on('employees')->onDelete('cascade');
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
