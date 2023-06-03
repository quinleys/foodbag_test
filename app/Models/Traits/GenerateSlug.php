<?php

namespace App\Models\Traits;
use Spatie\Sluggable\SlugOptions;

trait GenerateSlug {

    protected string $sluggableField = 'name';

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->sluggableField)
            ->saveSlugsTo('slug');
    }
}
