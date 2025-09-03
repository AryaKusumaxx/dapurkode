<?php

namespace App\Console\Commands;

use App\Services\WarrantyService;
use Illuminate\Console\Command;

class CheckExpiredWarranties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warranties:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update expired warranties';

    /**
     * Create a new command instance.
     */
    public function __construct(
        protected WarrantyService $warrantyService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking for expired warranties...');
        
        $count = $this->warrantyService->updateExpiredWarranties();
        
        $this->info("Updated status for {$count} expired warranties.");
        
        return Command::SUCCESS;
    }
}
