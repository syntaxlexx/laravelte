<?php

use App\Actions\Admin\Cms\ContactMessages;
use App\Actions\Admin\CMS\ContactMessagesDelete;
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
        Route::match(['GET', 'POST'], '/configurations', Configurations::class)->name('configurations');
        Route::match(['GET', 'POST'], '/reset-system', ResetSystem::class)->name('reset-system');
    });

    Route::group(['prefix'=> 'cms', 'as' => 'cms.'], function() {
        Route::match(['GET', 'POST'], '/contact-messages', ContactMessages::class)->name('contact-messages');
        Route::delete('/contact-messages/{id}', ContactMessagesDelete::class)->name('contact-messages.destroy');
    });

});
