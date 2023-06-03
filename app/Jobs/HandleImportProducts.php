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
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Bus::batch($this->generateJobsChain())
            ->catch(function (Batch $batch) {
                // All jobs that have run are finished
                // notify user something when wrong
                //            $batch->add(new SendSyncSuccessMail($order));
            })
            ->then(function (Batch $batch) {
//            $batch->add(new SendSyncSuccessMail($order));
            })
            ->name('Import products')
            ->dispatch();
    }

    // Generate a chain of jobs
    public function generateJobsChain(): array
    {
        $products = json_decode(file_get_contents(storage_path('app/foodbag_products.json')), true);

        $jobs = [];

        foreach ($products['ExtraProductVariants'] as $product) {
            $jobs[] = [
                new ImportAllergy($product['Allergies']),
                new ImportProductCategory($product['ProductCategoryNL']),
                new ImportProduct($product)
            ];
        }

        return $jobs;
    }
}
