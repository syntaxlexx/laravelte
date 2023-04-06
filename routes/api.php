<?php

use App\Actions\Auth\Login;
use App\Actions\Auth\Logout;
use App\Actions\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('user');


Route::post('/login', Login::class)->middleware(['guest', 'throttle:20,1'])->name('login');
Route::post('/register', Register::class)->middleware(['guest', 'throttle:20,1'])->name('register');
Route::post('/logout', Logout::class)->middleware('auth:sanctum')->name('logout');
