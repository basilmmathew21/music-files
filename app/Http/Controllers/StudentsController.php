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
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentsController extends Controller
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
        /**
         * Ajax call by datatable for listing of the students.
         */
       
        if ($request->ajax()) {
             $data = User::with('student')
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->select(['users.*','students.is_active as is_active','students.is_registered','courses.course','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
            ->where('user_type_id', 4)
            ->get();

            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name'] ), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }

                })
                ->addIndexColumn()
                ->addColumn('action', function ($student) {
                    return view('students.datatable', compact('student'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

       $student = User::paginate(25);
        return view('students.index', compact('student'));
    }

    /**
     * Show the form for creating a new student.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $nationalities  = Country::pluck('name', 'id')->all();
        $courses        = Course::pluck('course', 'id')->all();
        $currency       = Currency::select(['symbol','code', 'id'])->get();
        return view('students.create', compact('nationalities','courses','currency'));
    }

    /**
     * Store a new student in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);
        $data['password']       = Hash::make($data['password']); //Encrypting password
        $data['country_id']     = $data['country']; //country
        $data['state']          = $request->state;
        $data['address']        = $request->address;
        $data['dob']            = Carbon::createFromFormat('d-m-Y',$request->dob)->format('Y-m-d');
        $data['user_type_id']   = 4;
        $data['is_active']      =  $request->status;
        if ($request->hasFile('profile_image')) {

            $profile_image_path = $request->file('profile_image')->store('students/profile');
            $data['profile_image'] =  $profile_image_path;
        }
        User::create($data);
        
        $newuser = User::where('email', '=', $data['email'])->where('user_type_id', 4)->first()->toArray();
        $student['user_id']        =  $newuser['id'];
        $student['country_id']     =  $data['country'];
        $student['course_id']      =  $request->course;
        $student['currency_id']    =  $request->currency;
        $student['class_fee']      =  $request->class_fee;
        $student['is_registered']  =  1;
        $student['is_active']      =  $request->status;
        Student::create($student);
        
        return redirect()->route('students.student.index')
            ->with('success_message', trans('students.model_was_added'));
        

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
                                ->select(['users.*','students.is_active as is_active','students.class_fee','students.is_registered','students.country_id','students.course_id','students.currency_id',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob')])
                                ->findOrFail($id);
        $nationalities  = Country::pluck('name', 'id')->all();
        $courses        = Course::pluck('course', 'id')->all();
        $currency       = Currency::select(['symbol','code', 'id'])->get();
        return view('students.edit', compact('nationalities','courses','currency','user'));

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
        $data['user_type_id']   = 4;
        $data['is_active']      = $request->status;
        if ($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('students/profile');
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
        
        $studentDetais                  =  Student::where('user_id', $id)->first();
        
        if($studentDetais && $studentDetais != null){
            $student['country_id']     =  $request->country;
            $student['course_id']      =  $request->course;
            $student['currency_id']    =  $request->currency;
            $student['class_fee']      =  $request->class_fee;
            $student['is_registered']  =  $request->is_registered;
            $student['is_active']      =  $request->status;
            $studentDetais->update($student);
        }
        return redirect()->route('students.student.index')
            ->with('success_message', trans('students.model_was_updated'));
    }




    /**
     * Display the specified student.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::with('student')
                    ->join('countries', 'users.country_id', '=', 'countries.id')
                    ->leftJoin('students', 'students.user_id', '=', 'users.id')
                    ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
                    ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
                    ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
                    ->select(['users.*','students.is_active as is_active','students.class_fee','user_types.user_type','currencies.code','currencies.symbol','students.is_registered','courses.course','countries.name AS country_name',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") as dob'),DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                    ->findOrFail($id);
        return view('students.show', compact('user'));
    }



    /**
     * Remove the specified student from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $student = Student::where('user_id', $id);
            $student->delete();

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('students.index')
                ->with('success_message', trans('students.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('students.unexpected_error')]);
        }
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
                'required',
                Rule::unique('users')->where(function ($query) {
                }),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                }),
            ],
            'password' => 'required|string|min:1|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'country' => 'nullable',
            'class_fee' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules,[
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    }),
                ],
                'phone' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                    }),
                ],
                'password' => 'nullable|string|min:1|max:255',
            ]);
        }
        
        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}
