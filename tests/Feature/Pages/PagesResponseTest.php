<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('gives back successful response for home page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('gives back successful response for blade test page', function () {
    // Act & Assert
    get(route('pages.blade-test'))
        ->assertOk();
});

it('gives back successful response for livewire test page', function () {
    // Act & Assert
    get(route('pages.livewire-test'))
        ->assertOk();
});
