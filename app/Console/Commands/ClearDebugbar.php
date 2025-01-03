<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearDebugbar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-debugbar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $debugbarPath = storage_path('debugbar');

        if (File::exists($debugbarPath)) {
            File::delete(File::files($debugbarPath));
            $this->info('Debugbar files cleared successfully.');
        } else {
            $this->info('Debugbar folder does not exist.');
        }
    }
}
