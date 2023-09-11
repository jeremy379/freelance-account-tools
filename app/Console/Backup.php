<?php

namespace App\Console;

use Illuminate\Console\Command;

class Backup extends Command
{
    protected $signature = 'backup';

    protected $description = 'Backup database';

    public function __invoke()
    {
        $databaseName = env('DB_DATABASE');
        $username = env('DB_ROOT_USER');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $timestamp = now()->format('YmdHis');
        $dumpFileName = "dump_{$databaseName}_{$timestamp}.sql";

        $command = "mysqldump -h{$host} -u{$username} -p{$password} {$databaseName} > {$dumpFileName}";

        exec($command);

        $this->info("Database dump saved as {$dumpFileName}");
    }
}
