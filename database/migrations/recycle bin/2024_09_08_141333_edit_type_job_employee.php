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
        //     $table->integer('position_id')->change();
        //     $table->integer('schedule_id')->change();
        //     $table->integer('calendar_id')->change();
        //     $table->integer('job_title')->change();
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
