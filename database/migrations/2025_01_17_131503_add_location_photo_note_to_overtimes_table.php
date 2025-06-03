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
        Schema::table('overtimes', function (Blueprint $table) {
            $table->string('note')->nullable()->after('status');
            $table->string('location_in')->nullable()->after('note');
            $table->string('location_out')->nullable()->after('location_in');
            $table->string('photo_in')->nullable()->after('location_out');
            $table->string('photo_out')->nullable()->after('photo_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->dropColumn(['note', 'location_in', 'location_out', 'photo_in', 'photo_out']);
        });
    }
};
