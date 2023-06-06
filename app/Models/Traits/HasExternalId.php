<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasExternalId
{
    public static function bootHasExternalId(): void
    {
        static::creating(function ($model) {
            $model->external_id = $model->generateExternalId();
        });
    }

    public function generateExternalId(): string
    {
        return (string) Str::uuid();
    }
}
