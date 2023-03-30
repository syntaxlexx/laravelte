<?php

use App\Actions\User\Dashboard;
use App\Models\User;

Route::group([
    'middleware' => [
        'auth:sanctum',
        'role:' . implode('|', [User::ROLE_USER]),
        'verified',
    ],
    'as' => 'user.',
    'prefix' => 'portal',
], function() {

    Route::get('/', Dashboard::class)->name('dashboard');

});
