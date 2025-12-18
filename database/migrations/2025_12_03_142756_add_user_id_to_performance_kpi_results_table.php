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
        Schema::table('performance_kpi_results', function (Blueprint $table) {
            $table->unsignedBigInteger('user_created')->nullable()->after('id');
            $table->unsignedBigInteger('user_updated')->nullable()->after('user_created');

            $table->foreign('user_created')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->default(null);
            $table->foreign('user_updated')
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
        Schema::table('performance_kpi_results', function (Blueprint $table) {
            $table->dropColumn('user_created', 'user_updated');
        });
    }
};
