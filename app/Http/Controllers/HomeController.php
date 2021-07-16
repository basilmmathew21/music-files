<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Models\User;

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

        return view('home', compact('users','students','tutors','credits'));
    }
}
