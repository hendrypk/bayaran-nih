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
        schema::table('employees', function (Blueprint $table){
            $table->string('position');
            $table->string('jobTitle');
            $table->string('division');
            $table->string('department');
            $table->string('joiningDate');
            $table->string('workSchedule');
            $table->string('workCalendar');
            $table->string('employeeStatus');
            $table->string('salesStatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
