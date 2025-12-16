<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDailyAbsence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-absence {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily absence for active employees';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $date = $this->option('date')
            ? Carbon::parse($this->option('date'))->toDateString()
            : Carbon::today()->toDateString();

        $this->info('Generating absence for date: {$date}');

        $employees = Employee::whereNull('resignation_date')->get();
        
        DB::transaction(function () use ($employees, $date) {
            foreach ($employees as $employee) {
                Presence::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'date' => $date,
                    ],
                    [
                        'status' => 'absence'
                    ]
                );
            }
        });

        $this->info('Daily absence generated successfully');
        
        return self::SUCCESS;

    }
}
