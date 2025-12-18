<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\EmployeeWorkSchedule;
use App\Models\WorkScheduleDay;
use App\Models\WorkScheduleGroup;
use Illuminate\Console\Command;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class MigrateWorkSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-work-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old work schedules into groups and days tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldSchedules = FacadesDB::table('work_days')->get();
        $grouped = $oldSchedules->groupBy('name');

        foreach ($grouped as $name => $schedules) {
            $group = WorkScheduleGroup::firstOrCreate(
                ['name' => $name],
                [
                    'count_late'  => (bool) ($schedules->first()->count_late ?? true),
                    'tolerance'   => $schedules->first()->tolerance ?? 0,
                ]
            );

            foreach ($schedules as $schedule) {
                WorkScheduleDay::updateOrCreate(
                    [
                        'work_schedule_group_id' => $group->id,
                        'day'                    => $schedule->day,
                    ],
                    [
                        'arrival'     => $schedule->arrival,
                        'start_time'  => $schedule->arrival ?? $schedule->check_in,
                        'end_time'    => $schedule->check_out,
                        'break_start' => $schedule->break_in,
                        'break_end'   => $schedule->break_out,
                        'is_offday'   => (bool) $schedule->day_off,
                        'count_break' => (bool) ($schedule->break ?? false),
                    ]
                );
            }
        }

        $this->info('Work schedule groups and days migrated. Now migrating employee_work_days...');

        // Buat mapping work_day lama → work_schedule_group baru lewat nama
        $workDayToGroup = FacadesDB::table('work_days')
            ->join('work_schedule_groups', 'work_days.name', '=', 'work_schedule_groups.name')
            ->select('work_days.id as old_id', 'work_schedule_groups.id as new_group_id')
            ->get()
            ->pluck('new_group_id', 'old_id');


        // Migrasi employee_work_day → employee_work_schedules
        $oldEmployeeSchedules = FacadesDB::table('employee_work_day')->get();

        foreach ($oldEmployeeSchedules as $old) {
            if (!$old->employee_id || !$old->work_day_id) {
                $this->warn("Skipping record: employee_id={$old->employee_id} work_day_id={$old->work_day_id}");
                continue;
            }

            $groupId = $workDayToGroup[$old->work_day_id] ?? null;

            if (!$groupId) {
                $this->warn("work_day_id {$old->work_day_id} tidak ditemukan di mapping. Skipping...");
                continue;
            }

            EmployeeWorkSchedule::create([
                'employee_id'            => $old->employee_id,
                'work_schedule_group_id' => $groupId,
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
        }

        $this->info('Employee work schedules migrated successfully!');

        $this->info('Migration completed successfully!');
    }
}
