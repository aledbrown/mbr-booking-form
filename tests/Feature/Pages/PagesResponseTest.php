<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;
uses(RefreshDatabase::class);

it('gives back successful response for home page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('gives back successful response for thank you page', function () {
    // Act & Assert
    get(route('pages.booking-form.thank-you'))
        ->assertOk();
});
