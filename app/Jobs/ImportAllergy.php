<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ImportAllergy implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $allergies)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->allergies as $allergy) {
            \App\Models\Allergy::UpdateOrCreate([
                'name' => $allergy['NameNL'],
                'slug' => Str::of($allergy['NameNL'])->slug(),
            ]);
        }
    }
}
