<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StudentTestimonialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role_or_permission:student']);
    }

    /**
     * Show the form for creating a new student.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {

        return view('student_testimonial.create');
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
        $data['title']       = $request->title; //Encrypting password
        $data['description']     = $request->description; //country
        $data['status']          = 'pending';
        $data['is_active']        = '1';
        $data['user_id']            =  \Auth::user()->id;
        Testimonial::create($data);

        return redirect()->route('student.testimonial.show')
            ->with('success_message', trans('testimonial.model_was_added'));
    }



    /**
     * Display the specified student.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show()
    {
       
        $student_testimonial = Testimonial::where('user_id', \Auth::user()->id)->first();
        
        if ($student_testimonial)
            $testimonial           = Testimonial::with('user')->findOrFail($student_testimonial->id)->first();
        else
            $testimonial = [];
        //print_r($testimonial); exit;
        return view('student_testimonial.show', compact('testimonial'));
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

            $testimonial = Testimonial::findOrFail($id);
            $testimonial->delete();

            return redirect()->route('student_testimonial.show')
                ->with('success_message', trans('testimonial.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('testimonial.unexpected_error')]);
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
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string',
            //'status' => 'required',
            'is_active' => 'nullable'
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules =  [
                'is_active' => 'nullable'
            ];
        }

        $data = $request->validate($rules);

        return $data;
    }
}
