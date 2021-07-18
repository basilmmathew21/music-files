<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Models\User;
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
        $users      = User::count();
        $students   = User::with('student')
                    ->Join('students', 'students.user_id', '=', 'users.id')
                    ->where('user_type_id', 4)
                    //->where('users.is_active','1')
                    ->count();
        $tutors     = User::where('user_type_id', 3)
                    ->Join('tutors', 'tutors.user_id', '=', 'users.id')
                    //->where('users.is_active','1')
                    ->count();
        $credits   = User::with('student')
                    ->Join('students', 'students.user_id', '=', 'users.id')
                    ->where('user_type_id', 4)
                    //->where('users.is_active','1')
                    ->sum('credits');

        $studentInfo = User::with('student')
                    ->join('countries', 'users.country_id', '=', 'countries.id')
                    ->join('students', 'students.user_id', '=', 'users.id')
                    ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                    ->select(['users.*','students.is_active as is_active','students.is_registered','courses.course','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                    ->where('user_type_id', 4)
                    ->limit(10)
                    ->orderBy('students.created_at','desc')
                    ->get();
        
        $tutorInfo  = DB::table('users')
                    ->join('countries', 'users.country_id', '=', 'countries.id')
                    ->select(['users.*','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                    ->where('user_type_id', 3)
                    ->limit(10)
                    ->get();

        return view('home', compact('users','students','tutors','credits','studentInfo','tutorInfo'));
    }
}
