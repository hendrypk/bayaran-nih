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
        // schema::table('performance_kpis', function(Blueprint $table){
        //     $table->dropForeign(['job_title']);
        //     $table->dropColumn('job_title');
        //     $table->string('position');
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