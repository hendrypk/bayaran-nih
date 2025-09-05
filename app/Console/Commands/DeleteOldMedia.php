<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteOldMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-media';

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
        // $baseDir = storage_path('app/public');
        // $files = File::allFiles($baseDir);
        // $deleted = 0;

        // foreach ($files as $file) {
        //     $modified = Carbon::createFromTimestamp($file->getMTime());

        //     if (now()->diffInDays($modified) > 60) {
        //         File::delete($file);
        //         $deleted++;
        //     }
        // }
        $path = storage_path('app/public');
        $files = File::files($path);

        foreach ($files as $file) {
            if (now()->diffInDays(Carbon::createFromTimestamp(File::lastModified($file))) > 60) {
                File::delete($file);
            }
        }

        $this->info('Old media deleted successfully.');
    }
}
