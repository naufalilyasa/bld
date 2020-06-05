<?php

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

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});


Route::get('/signin', function () {
    return view('auth.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');
