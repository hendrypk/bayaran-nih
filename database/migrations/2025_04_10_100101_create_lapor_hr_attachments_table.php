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
        Schema::create('lapor_hr_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapor_hr_id')->constrained('lapor_hr')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lapor_hr_attachments', function (Blueprint $table) {
            $table->dropIfExists('lapor_hr_attachments');
        });
    }
};
