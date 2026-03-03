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
            $table->unsignedBigInteger('creator')->nullable()->after('location_out');
            $table->unsignedBigInteger('updater')->nullable()->after('creator');

            $table->foreign('creator')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->default(null);
            $table->foreign('updater')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropColumn('creator', 'updater');
        });
    }
};
