<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\TutorClass;
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
        $isStudent  =   $user->hasRole('student');
        $isTutor    =   $user->hasRole('tutor');
        $isAdmin    =   $user->hasRole('super-admin');
        
        $users      = User::count();
        $students   = User::with('student')
                    ->Join('students', 'students.user_id', '=', 'users.id');

        
        $tutorClass = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id');
        $tutorClass = $tutorClass->select(['classes.*','users.name',DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')]);
        


        if($isTutor){
            $tutorClass = $tutorClass->where('tutor_user_id',$id);
        }

        if($isTutor){
            $students   =  $students->where('tutors.user_id',$id)
                                    ->Join('tutors', 'tutors.user_id', '=', 'users.id')
                                    ->Join('tutor_students', 'tutor_students.tutor_id', '=', 'users.id');
                                    
        }

        $students   =  $students->count();
        
        $tutorClass =  $tutorClass->limit(10)->orderBy('users.created_at','desc')->get();


        $sms       =  DB::table('sms')
                            ->select('sms.*','users.name',DB::raw('DATE_FORMAT(sms.sent_on, "%d-%b-%Y %h:%i:%s") as sent_on'))
                            ->leftjoin('users','users.id','=','sms.from_user_id');
        
        if($isTutor){
            $sms   =  $sms->where('to_user_id',$id);
        }
        $sms  =  $sms->limit(10)->orderby('sent_on','desc')->get();


        $tutors     = User::where('user_type_id', 3)
                    ->Join('tutors', 'tutors.user_id', '=', 'users.id')
                    //->where('users.is_active','1')
                    ->count();
        $credits   = User::with('student')
                    ->Join('students', 'students.user_id', '=', 'users.id')
                    ->where('user_type_id', 4)
                    //->where('users.is_active','1')
                    ->sum('credits');

        $studentInfo = DB::table('users')
                    ->join('countries', 'users.country_id', '=', 'countries.id')
                    ->LeftJoin('students', 'students.user_id', '=', 'users.id')
                    //->Join('tutors', 'tutors.user_id', '=', 'users.id')
                    ->Join('tutor_students', 'tutor_students.user_id', '=', 'users.id')
                    ->where('tutor_students.tutor_id',$id)
                    ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                    ->select(['users.*','courses.course','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                    ->limit(10)
                    ->orderBy('users.created_at','desc')
                    ->get();
        
        $tutorInfo      = [];
        if($isTutor){
            $tutorInfo  = DB::table('users')
                    ->where('users.id',$id)
                    ->select(['users.*'])
                    ->where('user_type_id', 3)
                    ->limit(10)
                    ->get();
        }

        return view('home', compact('users','students','tutors','credits','studentInfo','tutorInfo','tutorClass','sms','isStudent','isTutor','isAdmin'));
    }
}
