<?php

it('can create uuid on model', function () {
    $product = \App\Models\Product::factory()->create();
    expect($product->external_id)->toBeString();
});

it('can create generate external id', function () {
    $externalId = (new \App\Models\Product())->generateExternalId();

    expect($externalId)->toBeString()
        ->and(strlen($externalId))->toBe(36)
        ->and($externalId !== (new \App\Models\Product())->generateExternalId())->toBeTrue();
});
