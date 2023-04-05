<?php

use App\Actions\Admin\Dashboard;
use App\Actions\Admin\Settings\Configurations;
use App\Actions\Admin\Settings\ResetSystem;
use App\Models\User;

Route::group([
    'middleware' => [
        'auth:sanctum',
        'role:' . implode('|', [User::ROLE_ADMIN, User::ROLE_SUPERADMIN, User::ROLE_DEVELOPER]),
    ],
    'as' => 'admin.',
    'prefix' => 'admin',
], function() {

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::group(['prefix'=> 'settings', 'as' => 'settings.'], function() {
        Route::get('/configurations', Configurations::class)->name('configurations');
        Route::match(['GET', 'POST'], '/reset-system', ResetSystem::class)->name('reset-system');
    });

});
