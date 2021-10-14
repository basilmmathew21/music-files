<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get('/storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    echo $exitCode . ' - Storage link';
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('optimize');
    echo $exitCode . ' - Cache cleared';
});

Route::get('/migration', function () {
    $exitCode = Artisan::call('migrate');
    echo $exitCode . ' - Migrated';
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed --class=PermissionsSeeder');
    echo $exitCode . ' - Seeded Permissions for 1,2,3,4';
});
Route::get('/seed-country', function () {
    $exitCode = Artisan::call('db:seed --class=CountriesSeeder');
    echo $exitCode . ' - Seeded Countries for 1,2,3,4';
});


Route::get('/seed-currency', function () {
    $exitCode = Artisan::call('db:seed --class=CurrencySeeder');
    echo $exitCode . ' - Seeded currencies for 1,2,3,4';
});

Route::get('/seed-sms', function () {
    $exitCode = Artisan::call('db:seed --class=Sms_templatesSeeder');
    echo $exitCode . ' - Seeded currencies for 1,2,3,4';
});

Route::get('/shutdown', function () {
    Artisan::call('down');
});

Route::get('/live', function () {
    Artisan::call('up');
});


Route::get('lang/{locale}', 'HomeController@lang');

Route::get('/', function () {
    return redirect()->route('home');
})->middleware('auth');

Auth::routes();

Route::get('/registration', 'StudentsRegistrationController@create')->name('registration')->middleware('guest');
Route::post('/registration', 'StudentsRegistrationController@store')->name('registration.store')->middleware('guest');
Route::get('/thankyou', 'StudentsRegistrationController@thankyou')->name('thankyou')->middleware('guest');




Route::group([
    'prefix' => 'tutorenquiries',
], function () {
    Route::post('/create', 'TutorEnquiryController@store')
        ->name('tutorenquiries.tutorenquiry.store')->middleware('guest');
    Route::get('/create', 'TutorEnquiryController@create')
        ->name('tutorenquiries.tutorenquiry.create')->middleware('guest');
    Route::get('/thankyou-tutor', 'TutorEnquiryController@thankyou')
        ->name('tutorenquiries.tutorenquiry.thankyou')->middleware('guest');
});



Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/regfee', 'RegfeeController@paynow')->name('regfee.paynow'); //Regostration fee



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
    Route::get('/create', 'UsersController@create')->middleware(['permission:add users'])
        ->name('users.user.create');
    Route::get('/show/{user}', 'UsersController@show')
        ->name('users.user.show');
    Route::get('/{user}/edit', 'UsersController@edit')->middleware(['permission:edit users'])
        ->name('users.user.edit');
    Route::post('/', 'UsersController@store')->middleware(['permission:add users'])
        ->name('users.user.store');
    Route::put('user/{user}', 'UsersController@update')->middleware(['permission:update users'])
        ->name('users.user.update');
    Route::delete('/user/{user}', 'UsersController@destroy')->middleware(['permission:delete users'])
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
    Route::get('/create', 'CoursesController@create')->middleware(['permission:add courses'])
        ->name('courses.course.create');
    Route::get('/{course}/edit', 'CoursesController@edit')->middleware(['permission:edit courses'])
        ->name('courses.course.edit');
    Route::post('/', 'CoursesController@store')->middleware(['permission:add courses'])
        ->name('courses.course.store');
    Route::put('courses/{course}', 'CoursesController@update')->middleware(['permission:edit courses'])
        ->name('courses.course.update');
    Route::delete('/course/{course}', 'CoursesController@destroy')->middleware(['permission:delete courses'])
        ->name('courses.course.destroy');
});


Route::group([
    'middleware' => ['permission:view students'],
    'prefix' => 'students',
], function () {
    Route::get('/students', 'StudentsController@index')
        ->name('students.student.index');
    Route::get('/registered', 'StudentsController@registered')
        ->name('students.registered.index');    
    Route::get('/create', 'StudentsController@create')->middleware(['permission:add students'])
        ->name('students.student.create');
    Route::get('/show/{student}', 'StudentsController@show')
        ->name('students.student.show');
    Route::get('/{student}/edit', 'StudentsController@edit')->middleware(['permission:edit students'])
        ->name('students.student.edit');
    Route::post('/store', 'StudentsController@store')->middleware(['permission:add students'])
        ->name('students.student.store');
    Route::put('student/{student}', 'StudentsController@update')->middleware(['permission:edit students'])
        ->name('students.student.update');
    Route::delete('/student/{student}', 'StudentsController@destroy')->middleware(['permission:delete students'])
        ->name('students.student.destroy');
});


Route::group([
    'middleware' => ['permission:view users'],
    'prefix' => 'tutors',
], function () {
    Route::get('/', 'TutorController@index')
        ->name('tutors.tutor.index');
    Route::get('/create', 'TutorController@create')->middleware(['permission:add tutors'])
        ->name('tutors.tutor.create');
    Route::get('/show/{tutor}', 'TutorController@show')
        ->name('tutors.tutor.show');
    Route::get('/{tutor}/edit', 'TutorController@edit')->middleware(['permission:edit tutors'])
        ->name('tutors.tutor.edit');
    Route::post('/', 'TutorController@store')->middleware(['permission:add tutors'])
        ->name('tutors.tutor.store');
    Route::put('tutor/{tutor}', 'TutorController@update')->middleware(['permission:edit tutors'])
        ->name('tutors.tutor.update');
    Route::delete('/tutor/{tutor}', 'TutorController@destroy')->middleware(['permission:delete tutors'])
        ->name('tutors.tutor.destroy');
    Route::get('/sendcredentials/{tutor}', 'TutorController@sendcredentials')->middleware(['permission:add tutors'])
        ->name('tutors.tutor.sendcredentials');
});

Route::group([
    'middleware' => ['permission:view testimonials'],
    'prefix' => 'testimonial',
], function () {

    Route::get('/show/{id}', 'TestimonialsController@show')->name('testimonials.testimonial.show');
    Route::get('/{id}/edit', 'TestimonialsController@edit')->name('testimonials.testimonial.edit')->middleware(['permission:edit testimonials']);
    Route::get('/create', 'TestimonialsController@create')->name('testimonials.testimonial.create')->middleware(['permission:add testimonials']);
    Route::post('/store', 'TestimonialsController@store')->name('testimonials.testimonial.store')->middleware(['permission:add testimonials']);
    Route::put('/update/{id}', 'TestimonialsController@update')->name('testimonials.testimonial.update')->middleware(['permission:edit testimonials']);
    Route::delete('/delete/{id}', 'TestimonialsController@destroy')->name('testimonials.testimonial.destroy')->middleware(['permission:delete testimonials']);
    Route::get('/index', 'TestimonialsController@index')->name('testimonials.testimonial.index');
});

Route::group([
    'middleware' => ['permission:student testimonial'],
    'prefix' => 'student',
], function () {
    Route::get('/testimonial', 'StudentTestimonialController@show')->name('student.testimonial.show');
    Route::get('/create-testimonial', 'StudentTestimonialController@create')->name('student.testimonial.create');
    Route::post('/store-testimonial', 'StudentTestimonialController@store')->name('student.testimonial.store');
    Route::delete('/delete-testimonial/{id}', 'StudentTestimonialController@destroy')->name('student.testimonial.destroy');
});


Route::group([
    'middleware' => ['permission:view payments'],
    'prefix' => 'payments',
], function () {

    Route::get('/show/{id}', 'PaymentController@show')->name('payments.payments.show');
    Route::get('/{id}/edit', 'PaymentController@edit')->name('payments.payments.edit')->middleware(['permission:edit payments']);
    Route::get('/store', 'PaymentController@store')->name('payments.payments.store')->middleware(['permission:add payments']);
    Route::get('/create', 'PaymentController@create')->name('payments.payments.create')->middleware(['permission:add payments']);
    Route::put('/update/{id}', 'PaymentController@update')->name('payments.payments.update')->middleware(['permission:edit payments']);
    Route::delete('/delete/{id}', 'PaymentController@destroy')->name('payments.payments.destroy')->middleware(['permission:delete payments']);
    Route::get('/index', 'PaymentController@index')->name('payments.payments.index');
});

Route::group([
    'middleware' => ['permission:view payments'],
    'prefix' => 'paymentdue',
], function () {

    Route::get('/show/{id}', 'PaymentdueController@show')->name('paymentdue.paymentdue.show');
    Route::get('/{id}/edit', 'PaymentdueController@edit')->name('paymentdue.paymentdue.edit')->middleware(['permission:edit paymentdue']);
    Route::get('/store', 'PaymentdueController@store')->name('paymentdue.paymentdue.store')->middleware(['permission:add paymentdue']);
    Route::get('/create', 'PaymentdueController@create')->name('paymentdue.paymentdue.create')->middleware(['permission:add paymentdue']);
    Route::put('/update/{id}', 'PaymentdueController@update')->name('paymentdue.paymentdue.update')->middleware(['permission:edit paymentdue']);
    Route::delete('/delete/{id}', 'PaymentdueController@destroy')->name('paymentdue.paymentdue.destroy')->middleware(['permission:delete paymentdue']);
    Route::get('/index', 'PaymentdueController@index')->name('paymentdue.paymentdue.index');
});


Route::group([
    'middleware' => ['permission:view classes'],
    'prefix' => 'tutor/classes',
], function () {
    Route::get('/', 'TutorClassController@index')
        ->name('tutor.classes.index');
    Route::get('/create', 'TutorClassController@create')->middleware(['permission:add classes'])
        ->name('tutor.classes.create');
    Route::get('/show/{user}', 'TutorClassController@show')
        ->name('tutor.classes.show');
    Route::get('/{id}/edit', 'TutorClassController@edit')->middleware(['permission:edit classes'])
        ->name('tutor.classes.edit');
    Route::post('/', 'TutorClassController@store')->middleware(['permission:add classes'])
        ->name('tutor.classes.store');
    Route::put('update/{id}', 'TutorClassController@update')->middleware(['permission:edit classes'])
        ->name('tutor.classes.update');
    Route::delete('/tutor/classes/{id}', 'TutorClassController@destroy')->middleware(['permission:delete classes'])
        ->name('tutor.classes.destroy');
    Route::get('/remove_file', 'TutorClassController@removeFile')->middleware(['permission:edit classes'])
        ->name('tutor.classes.remove_file');
});
Route::post('/ajaxTutorStudents', 'TutorClassController@ajaxTutorStudents');
Route::post('/ajaxFeePayment', 'FeepaymentController@ajaxFeePayment');
Route::group([
    'middleware' => ['permission:view tutorenquiries'],
    'prefix' => 'tutorenquiries',
], function () {
    Route::get('/', 'TutorEnquiryController@index')
        ->name('tutorenquiries.tutorenquiry.index');
    Route::get('/show/{tutorenquiry}', 'TutorEnquiryController@show')
        ->name('tutorenquiries.tutorenquiry.show');
    Route::get('/accept/{tutorenquiry}', 'TutorEnquiryController@accept')->middleware(['permission:edit tutorenquiries'])
        ->name('tutorenquiries.tutorenquiry.accept');
    Route::get('/reject/{tutorenquiry}', 'TutorEnquiryController@reject')->middleware(['permission:edit tutorenquiries'])
        ->name('tutorenquiries.tutorenquiry.reject');
});


Route::group([
    'middleware' => ['permission:view dashboard'],
    'prefix' => 'profile',
], function () {
    Route::get('/profile', 'ProfilesController@index')
        ->name('profiles.profile.index');
    Route::get('/{profile}/edit', 'ProfilesController@edit')
        ->name('profiles.profile.edit');
    Route::put('profile/{profile}', 'ProfilesController@update')
        ->name('profiles.profile.update');
});

Route::group([
    'middleware' => ['permission:view fee payment'],
    'prefix' => 'fee',
], function () {
    Route::get('/feepay', 'FeepaymentController@index')->middleware(['permission:add fee payment'])
        ->name('feepayment.fee.index');

    Route::put('feepay/{fee}', 'FeepaymentController@update')->middleware(['permission:add fee payment'])
        ->name('feepayment.fee.update');
});

Route::group([
    'middleware' => ['permission:view sms'],
    'prefix' => 'sms',
], function () {
    Route::get('/inbox', 'SmsController@inbox')
        ->name('Sms.sms.inbox');
    Route::get('/sent', 'SmsController@sent')
        ->name('Sms.sms.sent');
    Route::get('/compose', 'SmsController@compose')
        ->name('Sms.sms.compose');
    Route::post('/insertMessage', 'SmsController@addmessage')
        ->name('Sms.sms.insert');
    Route::get('/tutor-inbox', 'SmsController@tutor_inbox')->middleware(['permission:view admin sms'])
        ->name('Sms.sms.tutorinbox');
    Route::get('/tutor-sent', 'SmsController@tutor_sent')->middleware(['permission:view admin sms'])
        ->name('Sms.sms.tutorsent');
    Route::get('/student-inbox', 'SmsController@student_inbox')->middleware(['permission:view admin sms'])
        ->name('Sms.sms.studentinbox');
    Route::get('/student-sent', 'SmsController@student_sent')->middleware(['permission:view admin sms'])
        ->name('Sms.sms.studentsent');
    Route::get('/read-message/{messageid}', 'SmsController@view_message')->middleware(['permission:view sms'])
        ->name('Sms.sms.viewmessage');
    Route::delete('/delete-message/{messageid}', 'SmsController@delete_message')->middleware(['permission:view admin sms'])
        ->name('Sms.sms.deletemessage');
});
