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
        Schema::table('positions', function (Blueprint $table) {
            $table->integer('job_title_id')->nullable()->change();
            $table->integer('division_id')->nullable()->change();
            $table->integer('department_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->integer('job_title_id')->nullable(false)->change();
            $table->integer('division_id')->nullable(false)->change();
            $table->integer('department_id')->nullable(false)->change();
        });
    }
};
