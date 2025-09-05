<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteOldMediaCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_delete_old_media_command_runs_successfully(): void
    {
        $exitCode = Artisan::call('app:delete-old-media');

        $this->assertEquals(0, $exitCode);
        $this->assertStringContainsString('success', Artisan::output()); // opsional, tergantung output command kamu
    }
}
