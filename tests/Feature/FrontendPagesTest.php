<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedConfigurations();
});

test('home screen can be rendered', function () {
    $response = $this->get('/');

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Home')
    );
})->group('browser');
