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
        schema::table('grade_kpi', function(Blueprint $table){
            $table->decimal('grade', 5, 2)->nullable()->change();
            $table->decimal('achievement', 5, 2)->nullable()->change();
        });

        schema::table('performance_kpis', function(Blueprint $table){
            $table->decimal('target, 5, 2')->change();
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
