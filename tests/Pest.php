<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

uses()->group('admin')->in('Feature/Admin');
uses()->group('user')->in('Feature/User');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/


/**
 * Set the currently logged in user for the application.
 *
 * @return TestCase
 */
function actingAs(Authenticatable $user, string $driver = null)
{
    return test()->actingAs($user, $driver);
}

/**
 * Sign in the given user or create new one if not provided.
 *
 * @param $user \App\User
 *
 * @return \App\User
 */
function actingAsSanctum($user = null) : User
{
    $user = $user ?: User::factory()->create();
    Sanctum::actingAs($user, ['*']);
    return $user;
}


function seedConfigurations() : void
{
    $configs = collect(config('system_configurations'))->map(function($item, $key) {
        return [
            'name' => $key,
            'type' => $item['type'],
            'value' => $item['default'] ?? null
        ];
    })->values();

    redis()->set('configurations', $configs);
}

function updateConfigurationValue(string $name, $value) : void
{
    $configs = redis()->get('configurations');
    $updated = $configs->map(function($item) use ($name, $value) {
        $item = (array) $item;

        if($item['name'] == $name) {
            $item['value'] = $value;
        }
        return $item;
    });

    redis()->set('configurations', $updated);
}

/**
 * provide the inertia headers to pass in requests
 */
function inertiaHeaders() : array
{
    return [
        'X-Inertia' => true
    ];
}

/**
 * create and return a user by a certain role
 * @param string $role
 * @return User
 */
function getUserByRole($role = User::ROLE_USER, $attributes = []) : User
{
    $user = User::factory()->create(array_merge([
        'role' => $role
    ], $attributes));

    return $user;
}

/**
 * assert sucess in browser post/put response
 */
function assertBrowserSuccess($response) : void
{
    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertValid()
        ->assertSessionHas('success')
        ->assertSessionMissing('error');
}
