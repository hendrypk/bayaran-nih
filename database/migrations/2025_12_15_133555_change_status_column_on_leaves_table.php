<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'status_old')) {
                $table->renameColumn('status', 'status_old');
            }
        });

        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'status')) {
                $table->enum('status', ['pending', 'accepted', 'rejected'])
                    ->default('pending')
                    ->after('note');
            }
        });


        // OPTIONAL: mapping data lama (jika sebelumnya pakai int)
        DB::table('leaves')->update([
            'status' => DB::raw("
                CASE
                    WHEN status_old = 1 THEN 'accepted'
                    WHEN status_old = 0 THEN 'pending'
                    ELSE 'rejected'
                END
            ")
        ]);

    
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('status_old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('status')->default(0);
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
