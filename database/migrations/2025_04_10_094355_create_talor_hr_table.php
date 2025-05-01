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
        Schema::create('lapor_hr', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('lapor_hr_category');
            $table->string('attachment');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_hr', function (Blueprint $table) {
            $table->dropIfExists('lapor_hr');
        });
    }
};
