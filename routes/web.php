<?php

use App\Actions\Frontend\About;
use App\Actions\Frontend\Contact;
use App\Actions\Frontend\Home;
use App\Actions\Frontend\PolicyPages;
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
Route::post('/contact', Contact::class)->middleware('throttle:' . config('auth.limiters.contact'))->name('contact.store');
Route::get('/policy-pages/{slug?}', PolicyPages::class)->name('policy-pages');

// auth
include 'modules/auth.php';

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('change-language');

Route::get('/demo', function () {
    return redirect()->to(route('login', [
        'is_demo' => true,
    ]));
})->name('demo');

Route::middleware([
    'auth:sanctum',
    'active',
])->group(function () {

    // handle default dashboard route
    Route::get('/dashboard', UserRedirector::class)->name('dashboard');

    // user
    include 'modules/user.php';

    // admin
    include 'modules/admin.php';
});
