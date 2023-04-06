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

test('about screen can be rendered', function () {
    $response = $this->get(route('about'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('About')
    );
})->group('browser');

test('contact screen can be rendered', function () {
    $response = $this->get(route('contact'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Contact')
    );
})->group('browser');
