<?php

use App\Events\UserLoggedIn;
use App\Jobs\SendLoginAlertEmail;
use App\Listeners\UserHasLoggedIn;
use App\Models\User;
use App\Notifications\NotifyUserOfLogin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedConfigurations();
    increaseThrottles();
});

test('login screen can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Auth/Login')
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

    Event::assertListening(
        UserLoggedIn::class,
        UserHasLoggedIn::class
    );
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

    Event::assertListening(
        UserLoggedIn::class,
        UserHasLoggedIn::class
    );
})->group('browser');


it('pushed a login alert job after login in', function () {
    $user = getUserByRole(User::ROLE_USER, [
        'created_at' => now()->subDay(),
    ]);

    Queue::fake();
    Notification::fake();

    $requestData = [
        'ip' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Linux; Android 10; SM-G996U Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36',
        'referer' => 'http://laravelte.test/login',
        'host' => 'laravelte.test',
        'url' => 'http://laravelte.test/login',
        'device_name' => 'Test device',
    ];

    event(new UserLoggedIn($requestData, $user));

    Queue::assertPushed(SendLoginAlertEmail::class);

    dispatch(new SendLoginAlertEmail($user, $requestData));

    $this->assertDatabaseHas('user_logins', [
        'ip_address' => $requestData['ip'],
    ]);
})->group('browser');

it('sends a notification after login in', function () {
    $user = getUserByRole(User::ROLE_USER, [
        'created_at' => now()->subDay(),
    ]);

    Notification::fake();

    $requestData = [
        'ip' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Linux; Android 10; SM-G996U Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36',
        'referer' => 'http://laravelte.test/login',
        'host' => 'laravelte.test',
        'url' => 'http://laravelte.test/login',
        'device_name' => 'Test device',
    ];

    dispatch(new SendLoginAlertEmail($user, $requestData));

    Notification::assertCount(1);

    Notification::assertSentTo($user, NotifyUserOfLogin::class, function ($notification, $channels) {
        // check channels or properties of $notification here
        return in_array('mail', $channels);

        // or maybe check for nexmo:
        // return in_array('nexmo', $channels);
    });
})->group('browser');

test('login mail alert is successfully rendered', function () {
    $user = getUserByRole(User::ROLE_ADMIN);

    $requestData = [
        'ip' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Linux; Android 10; SM-G996U Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36',
        'referer' => 'http://laravelte.test/login',
        'host' => 'laravelte.test',
        'url' => 'http://laravelte.test/login',
        'device_name' => 'Test device',
    ];

    $notification = new NotifyUserOfLogin($requestData);
    $rendered = $notification->toMail($user)->render();

    $this->assertStringContainsString("Someone just logged in to your account.", $rendered);
    $this->assertStringContainsString("View Login Activity", $rendered);
    $this->assertStringContainsString(route('dashboard'), $rendered);
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
