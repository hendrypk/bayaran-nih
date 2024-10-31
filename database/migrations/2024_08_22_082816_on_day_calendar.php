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
        schema::create('on_day_calendar', function(Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->string('jan');
            $table->string('feb');
            $table->string('mar');
            $table->string('apr');
            $table->string('may');
            $table->string('jun');
            $table->string('jul');
            $table->string('aug');
            $table->string('sep');
            $table->string('oct');
            $table->string('nov');
            $table->string('dec');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullabel();
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
