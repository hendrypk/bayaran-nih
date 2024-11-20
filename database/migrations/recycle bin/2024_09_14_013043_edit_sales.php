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
        schema::table('sales', function(Blueprint $table){
            $table->integer('person')->change();
            $table->renameColumn('person', 'employee_id')->change();
            $table->dropColumn('qtyAllin');
            $table->dropColumn('qtyMakloon');
            $table->dropColumn('total');
            $table->integer('qty');
            $table->integer('year')->change();
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
