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

Route::get('lang/{locale}', 'HomeController@lang');

Route::get('/', function () {
    return redirect()->route('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
//Route::get('/email', 'EmailsController@index')->name('email');
/*
Route::get('send-mail', function () {

    $email = ['message' => 'This is a test!'];
    \Mail::to('anishkmathew@gmail.com')->send(new \App\Mail\TestEmail($email));

    dd("Email is Sent.");
}); */
//Route::get("send-email", 'EmailController@sendEmail')->name('first.email');
Route::group([
    'middleware' => ['permission:view users'],
    'prefix' => 'users',
], function () {
    Route::get('/', 'UsersController@index')
        ->name('users.user.index');
    Route::get('/create', 'UsersController@create')
        ->name('users.user.create');
    Route::get('/show/{user}', 'UsersController@show')
        ->name('users.user.show');
    Route::get('/{user}/edit', 'UsersController@edit')
        ->name('users.user.edit');
    Route::post('/', 'UsersController@store')
        ->name('users.user.store');
    Route::put('user/{user}', 'UsersController@update')
        ->name('users.user.update');
    Route::delete('/user/{user}', 'UsersController@destroy')
        ->name('users.user.destroy');
});

Route::group([
    'middleware' => ['permission:view users'],
    'prefix' => 'students',
], function () {
    Route::get('/', 'StudentsController@index')
        ->name('students.student.index');
    Route::get('/create', 'StudentsController@create')
        ->name('students.student.create');
    Route::get('/show/{student}', 'StudentsController@show')
        ->name('students.student.show');
    Route::get('/{student}/edit', 'StudentsController@edit')
        ->name('students.student.edit');
    Route::post('/', 'StudentsController@store')
        ->name('students.student.store');
    Route::put('student/{student}', 'StudentsController@update')
        ->name('students.student.update');
    Route::delete('/student/{student}', 'StudentsController@destroy')
        ->name('students.student.destroy');
});
