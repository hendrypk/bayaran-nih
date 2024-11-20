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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('eid');
            $table->string('employee_name')->nullable();
            $table->string('work_day_id')->nullable();
            $table->date('date');
            $table->time('check_in');
            $table->integer('late_arrival')->default(0);
            $table->integer('late_check_in')->default(0);
            $table->time('check_out')->nullable();
            $table->integer('check_out_early')->nullable();
            $table->string('note_in')->nullable();
            $table->string('note_out')->nullable();
            $table->string('photo_in')->nullable();
            $table->string('photo_out')->nullable();
            $table->string('location_in')->nullable();
            $table->string('location_out')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
