<?php

namespace App\Jobs;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class HandleImportProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('imports');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Bus::batch($this->generateJobsChain())
            ->then(function (Batch $batch) {
                // All jobs completed successfully...
                // notify user of success
                SendSyncSuccessMail::dispatch();
            })
            ->catch(function (Batch $batch) {
                // All jobs that have run are finished
                // notify user something when wrong
            })
            ->name('Import products')
            ->dispatch();
    }

    // Generate a chain of jobs
    public function generateJobsChain(): array
    {
        $products = json_decode(file_get_contents(storage_path('app/foodbag_products.json')), true);

        $jobs = [];

        // Loop over the products and create a chain of jobs
        foreach ($products['ExtraProductVariants'] as $product) {
            $jobs[] = [
                new ImportAllergy($product['Allergies']),
                new ImportProductCategory($product['ProductCategoryNL']),
                new ImportProduct($product),
            ];
        }

        return $jobs;
    }
}
