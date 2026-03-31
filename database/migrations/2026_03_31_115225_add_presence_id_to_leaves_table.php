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
        if (!Schema::hasColumn('leaves', 'presence_id')) {
            Schema::table('leaves', function (Blueprint $table) {
                $table->foreignId('presence_id')
                      ->nullable()
                      ->after('id') 
                      ->constrained('presences')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('leaves', 'presence_id')) {
            Schema::table('leaves', function (Blueprint $table) {
                $table->dropForeign(['presence_id']);
                $table->dropColumn('presence_id');
            });
        }
    }
};
