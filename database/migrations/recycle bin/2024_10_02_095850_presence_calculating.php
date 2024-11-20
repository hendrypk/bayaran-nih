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
        Schema::table('presences', function (Blueprint $table) {
            $table->integer('late_arrival')->default(0)->after('check_in');
            $table->integer('late_check_in')->default(0)->after('late_arrival');
            $table->integer('check_out_early')->default(0)->after('check_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropColumn('late_arrival');
            $table->dropColumn('late_check_in');
            $table->dropColumn('check_out_early');
        });
    }
};
