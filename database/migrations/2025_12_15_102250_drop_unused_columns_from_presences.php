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
            $table->dropColumn([
                'eid',
                'employee_name',
                'leave',
                'leave_status',
                'leave_note',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->unsignedBigInteger('eid')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('leave')->nullable();
            $table->boolean('leave_status')->nullable();
            $table->string('leave_note')->nullable();
        });
    }
};
