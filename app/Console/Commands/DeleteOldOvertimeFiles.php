<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteOldOvertimeFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:overtimes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete overtime files older than 30 days based on filename date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/public/overtimes');
        $files = File::files($directory);
        $now = now();

        foreach ($files as $file) {
            $filename = $file->getFilename();

            // Ekstrak tanggal dari nama file, misal: 126-2025-05-30-17:14:23.jpg
            if (preg_match('/\d+-(\d{4}-\d{2}-\d{2})-\d{2}[:\-]?\d{2}[:\-]?\d{2}/', $filename, $matches)) {
                $fileDate = Carbon::parse($matches[1]);

                if ($fileDate->diffInDays($now) > 30) {
                    File::delete($file->getPathname());
                    $this->info("Deleted: $filename");
                }
            } else {
                $this->warn("Skipped (no date found): $filename");
            }
        }

        $this->info('Finished cleaning old overtime files.');
    }
}
