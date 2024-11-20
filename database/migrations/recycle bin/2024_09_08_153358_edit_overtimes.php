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
        // schema::table('overtime', function(Blueprint $table){
        //     $table->dropColumn('eid');
        //     $table->renameColumn('employee_name', 'employee_id');
        //     $table->integer('employee_id')->change();
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
