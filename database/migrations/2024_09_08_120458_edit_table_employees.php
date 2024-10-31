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
        // schema::table('employees', function(Blueprint $table){
        //     $table->renameColumn('position', 'position_id');
        //     $table->renameColumn('jobTitle', 'job_title');
        //     $table->renameColumn('workSchedule', 'schedule_id');
        //     $table->renameColumn('workCalendar', 'calendar_id');
        //     $table->renameColumn('employeeStatus', 'employee_status');
        //     $table->renameColumn('salesStatus', 'sales_status');
            
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
