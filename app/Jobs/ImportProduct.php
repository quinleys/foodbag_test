<?php

namespace App\Jobs;

use App\Models\Allergy;
use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProduct implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = \App\Models\Product::updateOrCreate([
            'name' => $this->product['NameNL'],
        ], [
            'subtitle' => $this->product['SubtitleNL'],
            'description' => $this->product['ProductDescription1NL'],
            'description_html' => $this->product['Description1NL'],
            'sequence' => $this->product['Sequence'] ?? 0,
            'product_sequence' => $this->product['ProductSequence'] ?? 0,
            'product_category_id' => \App\Models\ProductCategory::where('name', $this->product['ProductCategoryNL'])->first()->id,
        ]);

        $this->addImages($product, $this->product['DigitalAssets']);
        $this->addAllergies($product, $this->product['Allergies']);
    }

    public function addAllergies(Product $product, array $allergies): void
    {
        $models = Allergy::whereIn('name', collect($allergies)->pluck('NameNL'))->get();

        $product->allergies()->sync($models->pluck('id'));
    }

    public function addImages(Product $product, array $images): void
    {
        foreach ($images as $image) {
            $product->addMediaFromUrl($image['Url'])
                ->toMediaCollection('product_images');
        }
    }
}
