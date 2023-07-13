<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Monitor;
use Illuminate\Console\Command;

class MonitorImport extends Command
{
    protected $signature = 'monitor:import';

    protected $description = 'Command for import monitors from file';

    public function handle(): int
    {
        $file = fopen(storage_path('import.txt'), 'r');

        while(!feof($file)) {
            $line = fgets($file);

            if (empty(trim($line))) {
                continue;
            }

            [$url, $group] = explode('|', $line);

            $monitor = new Monitor();

            $monitor->url = $url;
            $monitor->group = $group;

            $monitor->save();
        }

        fclose($file);

        return Command::SUCCESS;
    }
}
