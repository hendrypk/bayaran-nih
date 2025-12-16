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
        DB::table('presences')
            ->whereNull('check_in')
            ->update(['status' => 'absence']);
        DB::table('presences')
            ->whereNotNull('check_in')
            ->update(['status' => 'presence']);
        DB::table('presences')
            ->where('leave', 'sick')
            ->update(['status' => 'sick']);
        DB::table('presences')
            ->where('leave', 'annual leave')
            ->update(['status' => 'leave']);
        DB::table('presences')
            ->where('leave', 'full day permit')
            ->update(['status' => 'permit']);
        DB::table('presences')
            ->where('leave', 'half day permit')
            ->update(['status' => 'halfday']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
