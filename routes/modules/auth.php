<?php

use App\Actions\Auth\Login;
use App\Actions\Auth\LoginLinkSent;
use App\Actions\Auth\LoginViaMagicLink;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use App\Actions\Auth\RequestPasswordReset;
use App\Actions\Auth\ResetPassword;
use App\Actions\Auth\VerifyLogin;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', Login::class)->middleware(['guest'])->name('login');
Route::post('/login', Login::class)->middleware(['guest', 'throttle:' . config('auth.limiters.login')])->name('login');
Route::get('/register', Register::class)->middleware(['guest'])->name('register');
Route::post('/register', Register::class)->middleware(['guest', 'throttle:' . config('auth.limiters.registration')])->name('register');
Route::post('/logout', Logout::class)->middleware('auth:sanctum')->name('logout');
Route::get('/forgot-password', RequestPasswordReset::class)->middleware('guest')->name('forgot-password');
Route::post('/forgot-password', RequestPasswordReset::class)->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');
Route::post('/reset-password', ResetPassword::class)->middleware('guest')->name('password.update');
Route::post('/login-via-magic-link', LoginViaMagicLink::class)->middleware(['guest', 'throttle:' . config('auth.limiters.login')])->name('login-via-magic-link');
Route::get('/login-link-sent', LoginLinkSent::class)->middleware('guest')->name('login-link-sent');
Route::get('/verify-login/{token}', VerifyLogin::class)->name('verify-login');
