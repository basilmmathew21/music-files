<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Models\Course;
use App\Models\Currency;
use App\Models\Student;
use Illuminate\Http\Request;
use Exception;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfilesController extends Controller
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
     * Display a listing of the students.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id     = Auth::user()->id;
        $user   = User::with('student')
        ->join('countries', 'users.country_id', '=', 'countries.id')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
        ->select(['users.*','users.is_active as is_active','user_types.user_type','currencies.code','currencies.symbol','students.is_registered','countries.name AS country_name',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob'),DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
        ->findOrFail($id);
        
        return view('profiles.index', compact('user'));
    }

    


     /**
     * Display the specified student.
     *
     * @param int $id-','id')->all();
     * /**
     * Show the form for editing the specified student.
     *
     * @param int $id
     *
     */
    public function edit($id)
    {

        $user           = User::with('student')
                                ->leftJoin('students', 'students.user_id', '=', 'users.id')
                                ->select(['users.*','students.is_active as is_active','students.is_registered','students.country_id','students.course_id','students.currency_id',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob')])
                                ->findOrFail($id);
        $nationalities  = Country::pluck('name', 'id')->all();
        $courses        = Course::pluck('course', 'id')->all();
        $currency       = Currency::select(['symbol','code', 'id'])->get();
        return view('profiles.edit', compact('nationalities','courses','currency','user'));

    }

    /**
     * Update the specified driver in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $data                   = $this->getData($request, $id);
        $user                   = User::findOrFail($id);
        $data['country_id']     = $request->country; 
        $data['state']          = $request->state;
        $data['address']        = $request->address;
        $data['dob']            = Carbon::createFromFormat('d-m-Y',$request->dob)->format('Y-m-d');
        unset($data['is_active']);//      = $request->status;
        if ($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('public/images/profile');
            $profile_image_path = str_replace("public/", "", $profile_image_path);
           $data['profile_image'] =  $profile_image_path;
        } else {
            $data['profile_image'] =  $user->profile_image;
        }
        //Update the password only if provided
        if ($data['password'] && !empty($data['password']))
            $data['password'] = Hash::make($data['password']); //Encrypting password
        else
            unset($data['password']);
        $user->update($data);
        /*
        $studentDetais                  =  Student::where('user_id', $id)->first();
        if($studentDetais && $studentDetais != null){
            $student['country_id']     =  $request->country;
            $student['course_id']      =  $request->course;
            $student['currency_id']    =  $request->currency;
            $student['is_registered']  =  $request->is_registered;
            $student['is_active']      =  $request->is_active;
            $studentDetais->update($student);
        }
        */
        return redirect()->route('profiles.profile.index')
            ->with('success_message', trans('users.model_was_updated'));
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request, $id = 0)
    {

        $rules = [
            'name' => 'required|string|min:1|max:255',
            'email' => [
                'regex:/(.+)@(.+)\.(.+)/i',
                Rule::unique('users')->where(function ($query) {
                }),
            ],
            'phone' => [
                'digits:10',
                Rule::unique('users')->where(function ($query) {
                }),
            ],
            'password' => 'required|string|min:8|max:255',
            'gender' => 'nullable',
            'dob' => 'date_format:d-m-Y',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules,[
                'email' => [
                    'regex:/(.+)@(.+)\.(.+)/i',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    }),
                ],
                'phone' => [
                    'digits:10',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    }),
                ],
                'password' => 'nullable|string|min:8|max:255',
            ]);
        }
        
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}
