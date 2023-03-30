<?php

use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use App\Actions\Frontend\About;
use App\Actions\Frontend\Contact;
use App\Actions\Frontend\Home;
use App\Actions\UserRedirector;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');

Route::match(['GET', 'POST'], '/login', Login::class)->middleware(['guest', 'throttle:20,1'])->name('login');
Route::match(['GET', 'POST'], '/register', Register::class)->middleware(['guest', 'throttle:20,1'])->name('register');
Route::post('/logout', Logout::class)->middleware('auth:sanctum')->name('logout');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('change-language');

Route::get('/demo', function() {
    return redirect()->to(route('login', [
        'username' => config('system.default.demo_username'),
        'password' => config('system.default.demo_password'),
    ]));
})->name('demo');

Route::middleware([
    'auth:sanctum',
    'active',
])->group(function () {

    // handle default dashboard route
    Route::get('/dashboard', UserRedirector::class)->name('dashboard');

    // user
    include 'modules/user-web.php';

    // admin
    include 'modules/admin-web.php';
});
