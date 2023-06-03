<?php

beforeEach(function () {
    $this->category = \App\Models\ProductCategory::factory()->create();
    $this->token = \App\Models\ApiToken::factory()->create();
});

it('can return category index route', function () {
    $this->get('/api/v1/product-categories', [
        'api-token' => $this->token->token,
    ])
        ->assertStatus(200);
});

it('can return category show route', function () {
    $this->get('/api/v1/product-categories/' . $this->category->external_id,
        [
            'api-token' => $this->token->token,
        ])
        ->assertStatus(200);
});
