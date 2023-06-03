<?php

beforeEach(function () {
    $this->allergy = \App\Models\Allergy::factory()->create();
    $this->token = \App\Models\ApiToken::factory()->create();
});

it('can return allergy index route', function () {
    $this->get('/api/v1/allergies', [
        'api-token' => $this->token->token,
    ])
        ->assertStatus(200);
});

it('can return allergy show route', function () {
    $this->get('/api/v1/allergies/' . $this->allergy->external_id,
        [
            'api-token' => $this->token->token,
        ])
        ->assertStatus(200);
});
