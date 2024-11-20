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
        schema::create('options', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted')->nullable();
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
