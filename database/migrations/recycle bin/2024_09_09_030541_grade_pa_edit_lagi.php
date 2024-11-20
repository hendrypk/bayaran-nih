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
        // schema::table('grade_pa', function(Blueprint $table){    
        //     $table->dropForeign(['employee_id']);
        //     $table->dropForeign(['appraisal_id']);});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('grade_pa', function (Blueprint $table) {
        //     // Kembalikan foreign key jika diperlukan
        //     $table->foreign('employee_id')->references('id')->on('employees');
        //     $table->foreign('appraisal_id')->references('id')->on('performance_appraisals');
        // });
    }
};
