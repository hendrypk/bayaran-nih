<?php

namespace Tests\Feature;

use App\Models\WorkScheduleGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WorkScheduleMigrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    use RefreshDatabase;

    /** @test */
    public function it_migrates_old_work_schedules_into_groups_and_days(): void
    {
        // Seed data dummy ke tabel lama "work_days"
        DB::table('work_days')->insert([
            [
                'name'       => 'Shift Pagi',
                'day'        => 'Monday',
                'arrival'    => '08:00:00',
                'check_out'  => '16:00:00',
                'break_in'   => '12:00:00',
                'break_out'  => '13:00:00',
                'day_off'    => 0,
                'count_late' => 1,
                'break'      => 0,
                'tolerance'  => 5,
            ],
            [
                'name'       => 'Shift Pagi',
                'day'        => 'Tuesday',
                'arrival'    => '08:00:00',
                'check_out'  => '16:00:00',
                'break_in'   => '12:00:00',
                'break_out'  => '13:00:00',
                'day_off'    => 0,
                'count_late' => 1,
                'break'      => 0,
                'tolerance'  => 5,
            ],
        ]);

        // Jalankan command
        $this->artisan('app:migrate-work-schedules')
            ->expectsOutput('Migration completed successfully!')
            ->assertExitCode(0);

        // Pastikan group terbentuk
        $this->assertDatabaseHas('work_schedule_groups', [
            'name'        => 'Shift Pagi',
            'count_late'  => true,
            'count_break' => false,
            'tolerance'   => 5,
        ]);

        // Pastikan hari-hari masuk ke tabel days
        $this->assertDatabaseHas('work_schedule_days', [
            'day'                   => 'Monday',
            'start_time'            => '08:00:00',
            'end_time'              => '16:00:00',
            'is_offday'             => false,
        ]);

        $this->assertDatabaseHas('work_schedule_days', [
            'day'                   => 'Tuesday',
            'start_time'            => '08:00:00',
            'end_time'              => '16:00:00',
            'is_offday'             => false,
        ]);

        // Pastikan relasi jalan
        $group = WorkScheduleGroup::where('name', 'Shift Pagi')->first();
        $this->assertNotNull($group);
        $this->assertCount(2, $group->days);
    }
}
