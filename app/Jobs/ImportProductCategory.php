<?php

namespace App\Jobs;

use App\Models\ProductCategory;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ImportProductCategory implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(public string $productCategoryName)
    {
        $this->onQueue('imports');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ProductCategory::updateOrCreate([
            'name' => Str::of($this->productCategoryName)->ucfirst()->value(),
            'slug' => Str::of($this->productCategoryName)->slug()->value(),
        ]);
    }
}
