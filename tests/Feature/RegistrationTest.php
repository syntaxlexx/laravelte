<?php

use App\Events\UserWasCreated;
use App\Listeners\UserHasBeenCreated;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedConfigurations();
    increaseThrottles();
});


test('register screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Auth/Register')
    );
})->group('browser');

it('can create a new user in user repository', function () {
    $userRepo = (new UserRepository(new User()));

    Event::fake();

    $user = $userRepo->create([
        'name' => 'test',
        'email' => 'email@gm.test',
        'password' => 'password',
    ], User::ROLE_DEFAULT);

    expect($user->email)->toBe('email@gm.test');
    expect($user->name)->toBe('test');

    Event::assertDispatched(UserWasCreated::class);

    Event::assertListening(
        UserWasCreated::class,
        UserHasBeenCreated::class
    );

})->group('setup');


it('cannot create a new user in userRepository with just name', function () {
    $userRepo = (new UserRepository(new User()));

    Event::fake();

    $user = $userRepo->create([
        'name' => 'test',
        'password' => 'password',
    ], User::ROLE_DEFAULT);

    expect($user)->toBeFalsy();

    Event::assertNotDispatched(UserWasCreated::class);

})->group('setup');

it('can create a new user in userRepository with just email', function () {
    $userRepo = (new UserRepository(new User()));

    Event::fake();

    $user = $userRepo->create([
        'email' => 'test@email.com',
        'password' => 'password',
    ], User::ROLE_DEFAULT);

    expect($user->email)->toBe('test@email.com');

    Event::assertDispatched(UserWasCreated::class);

})->group('setup');


test('new users can register', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', false);

    $response = $this->post(route('register'), [
        'first_name' => 'test',
        'last_name' => 'user',
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], inertiaHeaders());

    $this->assertGuest();

    $response->assertRedirect(route('login'));
})->group('browser');


test('new users cannot register if registration is closed', function () {
    updateConfigurationValue('allow_user_registrations', false);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', false);

    $response = $this->post(route('register'), [
        'first_name' => 'test',
        'last_name' => 'user',
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], inertiaHeaders());

    $this->assertGuest();

    $response->assertRedirect(route('home'));
})->group('browser');


test('new users cannot register if restricted to register via app', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', true);

    $response = $this->post(route('register'), [
        'first_name' => 'test',
        'last_name' => 'user',
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], inertiaHeaders());

    $this->assertGuest();

    $response->assertRedirect(route('home'));
})->group('browser');


test('new users must provide email', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'Test',
        'last_name' => 'User',
    ], inertiaHeaders());

    $response->assertSessionHasErrors('email');

})->group('browser');


test('new users can provide just email', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', false);

    $response = $this->post(route('register'), [
        'email' => 'test@email.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'Test',
        'last_name' => 'User',
    ], inertiaHeaders());

    $response->assertRedirect(route('login'));

})->group('browser');


test('new users can register and login afterwards', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', false);
    updateConfigurationValue('restrict_non_admin_users_to_login_via_mobile_app', false);

    $response = $this->post(route('register'), [
        'name' => 'test',
        'email' => 'test@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'Test',
        'last_name' => 'User',
    ], inertiaHeaders());

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('login'));

    $response2 = $this->post(route('login'), [
        'username' => 'test',
        'password' => 'password',
    ], inertiaHeaders());

    $this->assertAuthenticated();
    $response2->assertRedirect(route('user.dashboard'));

})->group('browser');



// API
// ---------------

test('api - new users can register', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', true);

    $response = $this->postJson(route('api.register'), [
        'first_name' => 'test',
        'last_name' => 'user',
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(200);

    $array = json_decode($response->content(), true);

    expect($array)->toHaveKeys(['user', 'message']);

})->group('api');

test('api - new users cannot register if registration is closed', function () {
    updateConfigurationValue('allow_user_registrations', false);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', true);

    $response = $this->postJson(route('api.register'), [
        'first_name' => 'test',
        'last_name' => 'user',
        'name' => 'test',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);

})->group('api');

test('api - new users must provide either name or email', function () {
    $response = $this->postJson(route('api.register'), [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    $response->assertStatus(422);

    $array = json_decode($response->content(), true);

    expect($array)->toHaveKeys(['message', 'errors', 'errors.email']);

})->group('api');


test('api - new users can register and login afterwards', function () {
    updateConfigurationValue('allow_user_registrations', true);
    updateConfigurationValue('restrict_users_to_register_via_mobile_app', true);

    $response = $this->postJson(route('api.register'), [
        'name' => 'test',
        'email' => 'test@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'first_name' => 'Test',
        'last_name' => 'User',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'user', 'message'
        ]);

    $response2 = $this->postJson(route('api.login'), [
        'username' => 'test',
        'password' => 'password',
        'device_name' => 'my device',
    ]);

    $response2->assertOk()
        ->assertJsonStructure([
            'user', 'access_token'
        ]);

})->group('api');

