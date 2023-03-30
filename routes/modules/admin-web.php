<?php

use App\Actions\Admin\Dashboard;
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

});
