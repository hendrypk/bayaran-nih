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
        Schema::table('lapor_hr', function (Blueprint $table) {
            $table->renameColumn('lapor_hr_category', 'category_id');
            $table->dropColumn('attachment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_hr', function (Blueprint $table) {
            $table->renameColumn('category_id', 'lapor_hr_category');
            $table->string('attachment')->nullable();
        });
    }
};
