<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

        try {
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

            $appName = config('app.name');

            $message = "✅ <b>{$appName}</b>\n"
                    . "<b>Daily Absence Generated</b>\n"
                    . "📅 Date: {$date}\n"
                    . "👥 Employees: {$employees->count()}\n"
                    . "🕒 Time: " . now()->format('H:i:s');


            $this->sendTelegram($message);

            $this->info('Daily absence generated successfully');

            return self::SUCCESS;

        } catch (\Throwable $e) {

            $this->sendTelegram(
                "❌ <b>Daily Absence FAILED</b>\n"
                . "📅 Date: {$date}\n"
                . "⚠️ Error: {$e->getMessage()}"
            );

            throw $e;
        }

        $this->info('Daily absence generated successfully');
        
        return self::SUCCESS;

    }

    private function sendTelegram(string $message): void
    {
        Http::post(
            "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
            [
                'chat_id' => config('services.telegram.chat_id'),
                'text' => $message,
                'parse_mode' => 'HTML',
            ]
        );
    }

}
