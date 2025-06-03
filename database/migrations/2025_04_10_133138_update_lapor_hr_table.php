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
        Schema::table('lapor_hrs', function (Blueprint $table) {
            $table->renameColumn('description', 'report_description');
            $table->date('report_date');
            $table->string('solve_date')->nullable();
            $table->string('solve_description')->nullable();
            $table->enum('status', ['open', 'on progress', 'close']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_hrs', function (Blueprint $table) {
            $table->renameColumn('report_description', 'description');
            $table->dropColumn('report_date');
            $table->dropColumn('solve_date');
            $table->dropColumn('solve_description');
            $table->dropColumn('status');
        });
    }
};
