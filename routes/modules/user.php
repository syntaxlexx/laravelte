<?php

use App\Actions\User\Dashboard;
use App\Actions\User\Profile\MainProfile;
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

    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', MainProfile::class)->name('profile');
    });

});
