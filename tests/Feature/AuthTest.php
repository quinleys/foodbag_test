<?php

use App\Models\ApiToken;

it('can authenticate', function () {
    $token = ApiToken::factory()->create();


    $this->get('/api/v1/heartbeat', [
        'api-token' => $token->token,
    ])->assertStatus(200);
});

it('can not authenticate', function () {
    $this->get('/api/v1/heartbeat', [
        'api-token' => 'random-token',
        'Accept' => 'application/json',
    ])->assertStatus(401);
});
