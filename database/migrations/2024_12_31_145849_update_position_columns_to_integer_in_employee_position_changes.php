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
        Schema::table('employee_position_changes', function (Blueprint $table) {
            $table->integer('old_position')->unsigned()->nullable()->change();
            $table->integer('new_position')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_position_changes', function (Blueprint $table) {
            $table->string('old_position', 255)->nullable()->change();
            $table->string('new_position', 255)->change();
        });
    }
};
