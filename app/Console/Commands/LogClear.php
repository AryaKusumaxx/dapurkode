<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogClear extends Command
{
    protected $signature = 'log:clear';
    protected $description = 'Clear Laravel log file';

    public function handle()
    {
        file_put_contents(storage_path('logs/laravel.log'), '');
        $this->info('Logs have been cleared!');
    }
}
