<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Traits\HasExternalId;
    use Traits\GenerateSlug;

    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'description',
        'description_html',
        'sequence',
        'product_sequence',
        'external_id',
    ];

    protected $casts = [
        'sequence' => 'integer',
        'product_sequence' => 'integer',
    ];

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class)
            ->withTimestamps();
    }

    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Allergy::class)
            ->withTimestamps();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')
            ->singleFile();
    }

    protected string $sluggableField = 'name';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->sluggableField)
            ->saveSlugsTo('slug');
    }
}
