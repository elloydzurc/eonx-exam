<?php

namespace App\Jobs;

use App\Domain\CustomersImporter;
use App\Repositories\CustomersRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class RenamePath
 *
 * @package App\Modules\AssetManager\Jobs
 */
class CustomersImportJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $importer = new CustomersImporter();
        $customers = $importer->import();

        if ($customers) {
            /** @var CustomersRepository $repository */
            $repository = app(CustomersRepository::class);
            $repository->populateRecords($customers);
        }
    }
}
