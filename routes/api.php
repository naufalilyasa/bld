<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Untuk auth
Route::group([
    'middleware'    => 'api',
    'prefix'        => 'auth',
    'namespace'     => 'API'
], function () {
    Route::post('/signin', 'AuthController@signin');
    Route::post('/signup', 'AuthController@signup');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
});

// Untuk documents
Route::group([
    'middleware'    => 'auth:api',
    'prefix'        => 'documents',
    'namespace'     => 'API'
], function () {
    Route::get('/{id?}', 'DocumentController@index');
    Route::post('/', 'DocumentController@store');
    Route::patch('/{id}', 'DocumentController@update');
    Route::delete('/{id?}', 'DocumentController@destroy');
});

// Untuk borrowers
Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'borrowers',
    'namespace'  => 'API'
], function () {
    Route::post('/borrows/{id?}', 'BorrowController@borrows'); // pinjam
    Route::patch('/returns/{id?}', 'BorrowController@returns'); // pengembalian
    Route::patch('/confirms/{id?}', 'BorrowController@confirms'); // konfirmasi
});

// Untuk users
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'users',
    'namespace' => 'API'
], function () {
    Route::get('/{id?}', 'UserController@index');
});
