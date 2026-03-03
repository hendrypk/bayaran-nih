<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->renameColumn('date', 'start_date');
            $table->date('end_date')->nullable()->after('start_date');
        });
        DB::statement('UPDATE leaves SET end_date = start_date WHERE end_date IS NULL');
        Schema::table('leaves', function (Blueprint $table) {
            $table->date('end_date')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->renameColumn('start_date', 'date');
            $table->dropColumn('end_date');
        });
    }
};
