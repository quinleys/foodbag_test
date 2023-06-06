<?php

use App\Jobs\HandleImportProducts;
use Illuminate\Support\Facades\Queue;

it('can run command', function () {
    $this->artisan('import:products')
        ->assertExitCode(0);
});

it('can launch job after command', function () {
    // mock queue
    Queue::fake();

    $this->artisan('import:products');

    // Assert that a job was pushed to queue
    Queue::assertPushed(HandleImportProducts::class);
});
