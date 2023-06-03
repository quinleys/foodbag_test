<?php

namespace App\Console\Commands;

use App\Jobs\HandleImportProducts;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to import products from a JSON file (stored in storage/app/products.json) into the database.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        HandleImportProducts::dispatch();

        $this->info('Import products job dispatched.');
        $this->info('Check the queue worker output to see the progress of the import.');
        $this->info(env('APP_URL') . '/horizon');
    }
}
