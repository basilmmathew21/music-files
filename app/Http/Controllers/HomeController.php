<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\TutorClass;
use App\Models\Classes;
use Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sets the language.
     *
     */
    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $user   = Auth::user();

        /*
         *
         * Tutor begins
         */
        $isAdmin            =   $user->hasRole('admin');
        $isSuperAdmin       =   $user->hasRole('super-admin');
        $isTutor            =   $user->hasRole('tutor');
        $isStudent          =   $user->hasRole('student');


        if ($isTutor) {

            $students       =   User::with('student')
                ->Join('students', 'students.user_id', '=', 'users.id');
            $students       =   $students->where('tutors.user_id', $id)
                ->Join('tutors', 'tutors.user_id', '=', 'users.id')
                ->Join('tutor_students', 'tutor_students.tutor_id', '=', 'users.id');
            $students       =   $students->count();

            $studentInfo    =   DB::table('users')
                ->join('countries', 'users.country_id', '=', 'countries.id')
                ->LeftJoin('students', 'students.user_id', '=', 'users.id')
                //->Join('tutors', 'tutors.user_id', '=', 'users.id')
                ->Join('tutor_students', 'tutor_students.user_id', '=', 'users.id')
                ->where('tutor_students.tutor_id', $id)
                ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                ->select(['users.*', 'students.display_name', 'courses.course', 'countries.name AS country_name', DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                ->limit(10)
                ->orderBy('users.created_at', 'desc')
                ->get();

            $tutorClass =   TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')
                ->LeftJoin('students', 'students.user_id', '=', 'classes.student_user_id');
            $tutorClass =   $tutorClass->select(['classes.*', 'students.display_name', 'users.name', DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')]);
            $tutorClass =   $tutorClass->where('tutor_user_id', $id);
            $tutorClass =   $tutorClass->limit(10)->orderBy('users.created_at', 'desc')->get();

            $sms        =   DB::table('sms')
                ->select('sms.*', 'students.display_name', 'users.name', DB::raw('DATE_FORMAT(sms.sent_on, "%d-%b-%Y %h:%i:%s") as sent_on'))
                ->leftjoin('users', 'users.id', '=', 'sms.from_user_id')
                ->LeftJoin('students', 'students.user_id', '=', 'sms.from_user_id');
            $sms        =   $sms->where('to_user_id', $id);
            $sms        =   $sms->limit(10)->orderby('sent_on', 'desc')->get();

            return view('dashboard.tutor', compact('students', 'studentInfo', 'tutorClass', 'sms'));
        }
        /* Tutor ends
         *
         *
         */



        /*
          * Student begins   
          *
          */


        if ($isStudent) {
            $classes        =   DB::table('classes')->where('classes.student_user_id', $id);
            $classes        =   $classes->count();

            $feesDue        =   DB::table('classes')->where('classes.student_user_id', $id);
            $feesDue        =   $feesDue->sum('class_fee');

            $credits        =    User::with('student')
                ->Join('students', 'students.user_id', '=', 'users.id')
                ->where('students.user_id', $id)
                ->sum('credits');

            $tutorClass     =   TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id');
            $tutorClass     =   $tutorClass->select(['classes.*', 'users.name', DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')]);
            $tutorClass     =   $tutorClass->where('student_user_id', $id);
            $tutorClass     =   $tutorClass->limit(10)->orderBy('users.created_at', 'desc')->get();

            $paymentHistory =    User::with('student')
                ->Join('payment_histories', 'payment_histories.student_user_id', '=', 'users.id')
                ->where('payment_histories.student_user_id', $id)
                ->select('payment_histories.*', DB::raw('DATE_FORMAT(payment_histories.payment_date, "%d-%b-%Y %h:%i:%s") as payment_date'))
                ->limit(10)->orderby('payment_histories.created_at', 'desc')->get();

            $sms            =   DB::table('sms')
                ->select('sms.*', 'users.name', 'tutors.display_name', DB::raw('DATE_FORMAT(sms.sent_on, "%d-%b-%Y %h:%i:%s") as sent_on'))
                ->leftjoin('users', 'users.id', '=', 'sms.from_user_id')
                ->LeftJoin('tutors', 'tutors.user_id', '=', 'sms.from_user_id');;
            $sms            =   $sms->where('to_user_id', $id);
            $sms            =   $sms->limit(10)->orderby('sent_on', 'desc')->get();


            return view('dashboard.student', compact('classes', 'feesDue', 'credits', 'paymentHistory', 'tutorClass', 'sms'));
        }

        /* Student ends
         *
         *
         */



        /*
          * Admin begins   
          *
          */




        if ($isAdmin || $isSuperAdmin) {

            $feesDue        =   DB::table('classes');
            $feesDue        =   $feesDue->sum('class_fee');

            $credits        =    User::with('student')
                ->Join('students', 'students.user_id', '=', 'users.id')
                ->sum('credits');

            $students       =   User::with('student')
                ->Join('students', 'students.user_id', '=', 'users.id')
                ->where("is_active",'1');
            //$students       =   $students->Join('tutors', 'tutors.user_id', '=', 'users.id')
            //->Join('tutor_students', 'tutor_students.tutor_id', '=', 'users.id');
            $students       =   $students->count();

            $classes        =   DB::table('classes');
            $classes        =   $classes->count();

            $studentInfo    =   DB::table('users')
                ->join('countries', 'users.country_id', '=', 'countries.id')
                ->LeftJoin('students', 'students.user_id', '=', 'users.id')
                //->Join('tutors', 'tutors.user_id', '=', 'users.id')
                //->Join('tutor_students', 'tutor_students.user_id', '=', 'users.id')
                ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                ->select(['users.*', 'students.display_name', 'courses.course', 'countries.name AS country_name', DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                ->limit(10)
                ->where("users.is_active",'1')
                ->orderBy('users.created_at', 'desc')
                ->get();


            $sms            =   DB::table('sms')
                ->select('sms.*', 'users.name', 'students.display_name as student_displayname', 'tutors.display_name as tutor_displayname', DB::raw('DATE_FORMAT(sms.sent_on, "%d-%b-%Y %h:%i:%s") as sent_on'))
                ->leftjoin('users', 'users.id', '=', 'sms.from_user_id')
                ->LeftJoin('students', 'students.user_id', '=', 'sms.from_user_id')
                ->LeftJoin('tutors', 'tutors.user_id', '=', 'sms.from_user_id');
            $sms            =   $sms->where('to_user_id', $id);
            $sms            =   $sms->limit(10)->orderby('sent_on', 'desc')->get();


            $tutorClass     =   TutorClass::leftJoin('users as student_user', 'student_user.id', '=', 'classes.student_user_id')
                ->leftjoin('users as tutor_user', 'tutor_user.id', '=', 'classes.tutor_user_id')
                ->leftjoin('students', 'students.user_id', '=', 'classes.student_user_id')
                ->leftjoin('tutors', 'tutors.user_id', '=', 'classes.tutor_user_id')
                ->leftjoin('courses', 'courses.id', '=', 'students.course_id')
                ->select(['classes.*', 'student_user.name as student_name', 'tutor_user.name as tutor_name', 'students.display_name as student_displayname', 'tutors.display_name as tutor_displayname', 'courses.course', DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')])
                ->limit(10)->orderBy('classes.created_at', 'desc')->get();
            foreach ($tutorClass as $class) {

                $class->tutor_displayname = $class->tutor_displayname . "(" . $class->tutor_name . ")";
                $class->student_displayname = $class->student_displayname . "(" . $class->student_name . ")";
            }
            //echo $tutorClass;exit;
            return view('dashboard.admin', compact('classes', 'feesDue', 'credits', 'students', 'studentInfo', 'sms', 'tutorClass'));
        }

        /*
          * Admin ends   
          *
          */

        /*
           *
           * Default
           */
        return view('home');
    }
}
