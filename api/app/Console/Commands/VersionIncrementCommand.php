<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VersionIncrementCommand extends Command
{
    protected $signature = 'version:inc';

    protected $description = 'Increment app version';

    public function handle(): int
    {
        $a = config('app');
        $v = config('version');

        $v['date'] = Carbon::now()->format('Y-m-d');
        $v['hash'] = md5("{$v['date']}".Str::random(8));

        $this->save($v);

        $this->info("{$a['name']} v{$v['date']}");

        return Command::SUCCESS;
    }

    protected function save(array $version): void
    {
        $file = config_path('version.php');

        file_put_contents($file, "<?php\n\nreturn [\n");

        foreach ($version as $k => $v) {
            file_put_contents($file, "    '{$k}' => '{$v}',\n", FILE_APPEND);
        }

        file_put_contents($file, '];', FILE_APPEND);
    }
}
