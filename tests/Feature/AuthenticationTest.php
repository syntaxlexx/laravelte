<?php

use App\Events\UserLoggedIn;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedConfigurations();
});

test('login screen can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Auth/Login')
    );
})->group('browser');

test('register screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Auth/Register')
    );
})->group('browser');


test('users can authenticate with username via the login screen', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', false);

    $user = getUserByRole(User::ROLE_USER);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('user.dashboard'));

    Event::assertDispatched(UserLoggedIn::class);

})->group('browser');

test('admins can authenticate with username via the login screen', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', false);

    $user = getUserByRole(User::ROLE_ADMIN);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard'));

    Event::assertDispatched(UserLoggedIn::class);

})->group('browser');


test('users can authenticate with email via the login screen', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', false);

    $user = getUserByRole(User::ROLE_USER);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('user.dashboard'));

    Event::assertDispatched(UserLoggedIn::class);

})->group('browser');


test('users cannot authenticate if restricted to use mobile app', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', true);

    $user = getUserByRole(User::ROLE_USER);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'password',
    ]);

    $this->assertGuest();

    $response->assertRedirect();

    Event::assertNotDispatched(UserLoggedIn::class);
})->group('browser');


test('admins can authenticate if users are restricted to use mobile app', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', true);

    $user = getUserByRole(User::ROLE_ADMIN);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard'));

    Event::assertDispatched(UserLoggedIn::class);
})->group('browser');


test('users cannot authenticate if already authenticated', function () {
    $user = getUserByRole(User::ROLE_USER);
    actingAsSanctum($user);

    Event::fake();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'password',
    ]);

    $response->assertRedirect()
        ->assertRedirect(route('dashboard'));

    Event::assertNotDispatched(UserLoggedIn::class);

})->group('browser');

test('users can not authenticate with invalid password', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', false);

    $user = getUserByRole();

    $response = $this->post(route('login'), [
        'username' => $user->name,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();

    $response->assertInvalid();
})->group('browser');


// API
// ---------------
test('api - users can authenticate with username', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', true);

    $user = getUserByRole();

    $response = $this->postJson('/api/login', [
        'username' => $user->name,
        'password' => 'password',
        'device_name' => 'test device',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['user', 'access_token']);

})->group('api');

test('api - users can authenticate with email', function () {
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', true);

    $user = getUserByRole();

    $response = $this->postJson('/api/login', [
        'username' => $user->email,
        'password' => 'password',
        'device_name' => 'test device',
    ]);

    $response->assertStatus(200);

    $response->assertOk()
        ->assertJsonStructure(['user', 'access_token']);

})->group('api');

