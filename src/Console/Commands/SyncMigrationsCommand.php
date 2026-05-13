<?php

namespace NuxtIt\RP\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncMigrationsCommand extends Command
{
    protected $signature = 'sync:migrations';

    protected $description = 'Sync existing migration files with the migrations table';

    public function handle(): int
    {
        $migrationsPath = database_path('migrations');

        if (!is_dir($migrationsPath)) {
            $this->error("Migrations directory not found: {$migrationsPath}");
            return Command::FAILURE;
        }

        $files = glob($migrationsPath . '/*_*.php');

        if (empty($files)) {
            $this->warn('No migration files found.');
            return Command::SUCCESS;
        }

        $this->info('Found ' . count($files) . ' migration files.');

        $inserted = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $exists = DB::table('migrations')->where('migration', $filename)->exists();

            if ($exists) {
                $skipped++;
                $this->line("  Skipped: {$filename}");
            } else {
                DB::table('migrations')->insert([
                    'migration' => $filename,
                    'batch' => DB::table('migrations')->max('batch') + 1 ?? 1,
                ]);
                $inserted++;
                $this->info("  Inserted: {$filename}");
            }
        }

        $this->newLine();
        $this->info("Migration sync complete: {$inserted} inserted, {$skipped} skipped.");

        return Command::SUCCESS;
    }
}