<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanDebugFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-debug-files';

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
        $filePath = storage_path('debugar');

        if (File::exists($filePath)) {
            File::delete($filePath);
            $this->info('Debug file deleted successfully.');
        } else {
            $this->info('Debug file not found.');
        }
    }
}
