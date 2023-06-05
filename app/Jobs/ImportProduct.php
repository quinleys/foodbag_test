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
use Illuminate\Support\Str;

class ImportProduct implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $product)
    {
        $this->onQueue('imports');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = \App\Models\Product::updateOrCreate([
            'name' => Str::of($this->product['NameNL'])->ucfirst()->value(),
            'slug' => Str::of($this->product['NameNL'])->slug()->value(),
        ], [
            'subtitle' => $this->product['SubtitleNL'],
            'description' => $this->product['ProductDescription1NL'],
            'description_html' => $this->product['Description1NL'],
            'sequence' => $this->product['Sequence'] ?? 0,
            'product_sequence' => $this->product['ProductSequence'] ?? 0,
        ]);

        $this->addImages($product, $this->product['DigitalAssets']);
        $this->addAllergies($product, $this->product['Allergies']);
        $this->addCategories($product);
    }

    public function addCategories(Product $product): void
    {
        $models = \App\Models\ProductCategory::where('name', $this->product['ProductCategoryNL'])->get();

        $product->productCategories()->sync($models->pluck('id'));
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
