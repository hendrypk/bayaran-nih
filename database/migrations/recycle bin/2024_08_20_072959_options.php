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
        schema::create('position', function(Blueprint $table){
            $table->id();
            $table->string('position')->unique();
        });
        schema::create('jobTitle', function(Blueprint $table){
            $table->id();
            $table->string('jobTitle')->unique();
        });
        schema::create('division', function(Blueprint $table){
            $table->id();
            $table->string('division')->unique();
        });
        schema::create('department', function(Blueprint $table){
            $table->id();
            $table->string('department')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
