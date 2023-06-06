<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeIsActive($query)
    {
        return $query->where('active', true);
    }

    protected static function booted(): void
    {
        static::creating(function ($apiToken) {
            $apiToken->token = (string) Str::uuid();
        });
    }
}
