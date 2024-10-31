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




        schema::create('overtime', function(Blueprint $table){
            $table->id();
            $table->string('eid')->unique();
            $table->string('employee_name');
            $table->date('date');
            $table->time('start_at');
            $table->time('end_at');
            $table->integer('total')->nullable();
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
