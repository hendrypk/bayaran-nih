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
        Schema::table('lapor_hr_attachments', function (Blueprint $table) {
            $table->enum('type', ['report', 'solve']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_hr_attachments', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
