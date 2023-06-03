<?php

beforeEach(function () {
    $this->product = \App\Models\Product::factory()->create();
    $this->token = \App\Models\ApiToken::factory()->create();
});

it('can return product index route', function () {
    $this->get('/api/v1/products',
        [
            'api-token' => $this->token->token,
        ])
        ->assertStatus(200);
});

it('can return product show route', function () {
    $this->get('/api/v1/products/' . $this->product->external_id,
        [
            'api-token' => $this->token->token,
        ])
        ->assertStatus(200);
});

it('can filter on name', function () {
    $wrongProduct = \App\Models\Product::factory([
        'name' => 'wrong',
    ])->create();

    $this->get('/api/v1/products?search=' . $this->product->name,
        [
            'api-token' => $this->token->token,
        ])
        ->assertStatus(200)
        ->assertJsonFragment([
            'name' => $this->product->name,
        ])
        ->assertJsonMissing([
            'name' => $wrongProduct->name,
        ]);
});
