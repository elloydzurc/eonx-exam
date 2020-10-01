<?php

namespace App\Console\Commands;

use App\Jobs\CustomersImportJob;
use Illuminate\Console\Command;

/**
 * Class ImportCustomers
 *
 * @package App\Console\Commands
 */
class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from API Provider';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Importing in progress...');
        dispatch_now(new CustomersImportJob());
        $this->info('Done...');
    }
}
