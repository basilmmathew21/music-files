<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\Course;
use App\Models\Currency;
use App\Models\Student;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use DB;
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
     * Display a listing of the customers.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        /**
         * Ajax call by datatable for listing of the drivers.
         */
       
        if ($request->ajax()) {
             $data = User::with('student')
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->leftJoin('students', 'students.user_id', '=', 'users.id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->select(['users.*','students.is_registered','courses.course','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
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
                    /*
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if($row['is_registered'] == 1) 
                            $isReg  =   'Yes';
                        else
                            $isReg  =   'No';

                        return $isReg;
                    });
                    */
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
     * Show the form for creating a new customer.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        //$country_code = Country::pluck('phone_code', 'id')->all();
        $nationalities = Country::pluck('name', 'id')->all();
        $courses = Course::pluck('course', 'id')->all();
        $currency = Currency::pluck('symbol', 'id')->all();
        //$cities =  City::where('is_active', 1)->pluck('name', 'id')->all();
        return view('students.create', compact('nationalities','courses','currency'));
    }

    /**
     * Store a new customer in the storage.
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
        $data['user_type_id']   = 4;
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
        $student['is_registered']  =  1;
        $student['is_active']      =  1;
        Student::create($student);
        
        return redirect()->route('students.student.index')
            ->with('success_message', trans('students.model_was_added'));
        
    }
    /**
     * Display the specified customer.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $customer = User::with('customer')->findOrFail($id);
        return view('customer.show', compact('customer'));
    }

    /**
     * Display the specified customer.
     *
     * @param int $id-','id')->all();
     * /**
     * Show the form for editing the specified driver.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $customer = User::with('customer')->findOrFail($id);
        $country_code = Country::pluck('phone_code', 'id')->all();
        $nationalities = Country::pluck('name', 'id')->all();
        $cities = City::where('is_active', 1)->pluck('name', 'id')->all();
        return view('customer.edit', compact('customer', 'country_code', 'nationalities', 'cities'));
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

        $data = $this->getData($request, $id);
        $user   =   User::findOrFail($id);
        $data['country_id'] = $data['country']; //driver user type
        $data['city_id'] =  $data['city']; //driver user type
        if ($request->hasFile('profile_image')) {
            $profile_image_path = $request->file('profile_image')->store('customers/profile');
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

        $customer = Customer::where('user_id', $id)->first();
        if ($request->hasFile('national_file')) {

            $national_file_path = $request->file('national_file')->store('customers/national');
            $data['national_file'] =  $national_file_path;
        } else {
            $data['national_file'] =  $customer->national_file;
        }
        if ($request->hasFile('license_file')) {

            $license_file_path = $request->file('license_file')->store('customers/license');
            $data['license_file'] =  $license_file_path;
        } else {
            $data['license_file'] =  $customer->license_file;
        }
        $customer_data['is_active'] = $data['is_active'];
        $customer_data['dob'] = $data['dob'];
        $customer_data['national_file'] = $data['national_file'];
        $customer_data['license_file'] = $data['license_file'];
        $customer_data['national_id'] = $data['national_id'];
        $customer_data['nationality_id'] = $data['nationality_id'];
        $customer->update($customer_data);
        return redirect()->route('customer.index')
            ->with('success_message', trans('customer.model_was_updated'));
    }

    /**
     * Remove the specified driver from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::where('user_id', $id);
            $customer->delete();

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('customer.index')
                ->with('success_message', trans('customer.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('customer.unexpected_error')]);
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
                    $query->where('user_type_id', 4);
                }),
            ],
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    $query->where('user_type_id', 4);
                }),
            ],
            'password' => 'required|string|min:1|max:255',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'country' => 'nullable',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
        
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = array_merge($rules, [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 4);
                    }),
                ],
                'phone' => [
                    'required',
                    Rule::unique('users')->ignore($id)->where(function ($query) {
                        $query->where('user_type_id', 4);
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
