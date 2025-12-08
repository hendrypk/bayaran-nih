<?php

use Carbon\Carbon;
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
        Schema::create('time_dimensions', function (Blueprint $table) {
            $table->id();
            $table->date('db_date')->unique();
            $table->year('year');
            $table->tinyInteger('month'); // 1-12
            $table->tinyInteger('day');   // 1-31
            $table->tinyInteger('quarter'); // 1-4
            $table->tinyInteger('week');    // 1-52/53
            $table->string('day_name');     // Monday - Sunday
            $table->string('month_name');   // January - December
            $table->boolean('holiday_flag')->default(false);
            $table->boolean('weekend_flag')->default(false);
            $table->string('event')->nullable();
            $table->timestamps();
        });

        // Insert dates 2025 - 2028
        $start = Carbon::create(2025, 1, 1);
        $end = Carbon::create(2028, 12, 31);

        $dates = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = [
                'db_date'      => $date->format('Y-m-d'),
                'year'         => $date->year,
                'month'        => $date->month,
                'day'          => $date->day,
                'quarter'      => ceil($date->month / 3),
                'week'         => $date->weekOfYear,
                'day_name'     => $date->format('l'),
                'month_name'   => $date->format('F'),
                'holiday_flag' => false,
                'weekend_flag' => in_array($date->dayOfWeek, [0]), // Sunday=0, Saturday=6
                'event'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            // Insert in batches of 1000 untuk menghindari memory overload
            if (count($dates) >= 1000) {
                DB::table('time_dimensions')->insert($dates);
                $dates = [];
            }
        }

        // Insert sisa
        if (count($dates) > 0) {
            DB::table('time_dimensions')->insert($dates);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_dimensions');
    }
};
