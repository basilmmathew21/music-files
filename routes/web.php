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
    'middleware' => ['permission:view settings'],
    'prefix' => 'settings',
], function () {
    Route::get('/', 'SettingsController@index')
        ->name('settings.settings.index');   
    Route::get('/{settings}/edit', 'SettingsController@edit')
            ->name('settings.settings.edit'); 
    Route::put('settings/{settings}', 'SettingsController@update')
            ->name('settings.settings.update');
});

Route::group([
    'middleware' => ['permission:view courses'],
    'prefix' => 'courses',
], function () {
    Route::get('/', 'CoursesController@index')
        ->name('courses.course.index');
    Route::get('/create', 'CoursesController@create')
        ->name('courses.course.create');
    Route::get('/{course}/edit', 'CoursesController@edit')
        ->name('courses.course.edit');
   Route::post('/', 'CoursesController@store')
        ->name('courses.course.store');
    Route::put('courses/{course}', 'CoursesController@update')
        ->name('courses.course.update');
    Route::delete('/course/{course}', 'CoursesController@destroy')
        ->name('courses.course.destroy');
    });

        
Route::group([ 
    'middleware' => ['permission:view students'],
    'prefix' => 'students',
], function () {
    Route::get('/students', 'StudentsController@index')
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


Route::group([  
    'middleware' => ['permission:view users'],
    'prefix' => 'tutors',
], function () {
    Route::get('/', 'TutorController@index')
        ->name('tutors.tutor.index');
    Route::get('/create', 'TutorController@create')
        ->name('tutors.tutor.create');
    Route::get('/show/{tutor}', 'TutorController@show')
        ->name('tutors.tutor.show');
    Route::get('/{tutor}/edit', 'TutorController@edit')
        ->name('tutors.tutor.edit');
    Route::post('/', 'TutorController@store')
        ->name('tutors.tutor.store');
    Route::put('tutor/{tutor}', 'TutorController@update')
        ->name('tutors.tutor.update');
    Route::delete('/tutor/{tutor}', 'TutorController@destroy')
        ->name('tutors.tutor.destroy');
});

Route::group([ 
    'middleware' => ['permission:view testimonials'],
    'prefix' => 'testimonial',
], function () {

        Route::get('/show/{id}', 'TestimonialsController@show')->name('testimonials.testimonial.show');
        Route::get('/{id}/edit', 'TestimonialsController@edit')->name('testimonials.testimonial.edit');

        Route::get('/create', 'TestimonialsController@create')->name('testimonials.testimonial.create');
        Route::put('/update/{id}', 'TestimonialsController@update')->name('testimonials.testimonial.update');
        Route::delete('/delete/{id}', 'TestimonialsController@destroy')->name('testimonials.testimonial.destroy');
        Route::get('/index', 'TestimonialsController@index')->name('testimonials.testimonial.index');
    });

    Route::group([  
        'middleware' => ['permission:view tutorenquiries'],
        'prefix' => 'tutorenquiries',
    ], function () {
        Route::get('/', 'TutorEnquiryController@index')
            ->name('tutorenquiries.tutorenquiry.index');      
        Route::get('/show/{tutorenquiry}', 'TutorEnquiryController@show')
            ->name('tutorenquiries.tutorenquiry.show');
       
    });