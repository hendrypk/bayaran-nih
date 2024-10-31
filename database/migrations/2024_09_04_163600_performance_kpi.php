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
        // schema::create('grade_kpi', function(Blueprint $table){
        //     $table->id();
        //     $table->string('eid');
        //     $table->string('name');
        //     $table->integer('indicator_id');
        //     $table->integer('grade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
