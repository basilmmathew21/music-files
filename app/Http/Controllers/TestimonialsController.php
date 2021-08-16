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

class TestimonialsController extends Controller
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
            $data = Testimonial::select('testimonials.*', 'users.name as name')
                ->join('students', 'testimonials.user_id', '=', 'students.user_id')
                ->join('users', 'students.user_id', '=', 'users.id')
                ->orderBy('testimonials.created_at', 'desc')
                ->get();

            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name'] . $row['title'] . $row['status']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($testimonial) {
                    return view('testimonial.datatable', compact('testimonial'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $testimonial = Testimonial::with('user')->paginate(25);
        //dd($testimonial);
        return view('testimonial.index', compact('testimonial'));
    }

    /**
     * Show the form for creating a new student.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {

        return view('testimonial.create');
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

        return redirect()->route('testimonials.testimonial.index')
            ->with('success_message', trans('testimonial.model_was_added'));
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

        $testimonial           = Testimonial::with('user')->findOrFail($id);
        return view('testimonial.edit', compact('testimonial'));
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
        $testimonial                   = Testimonial::findOrFail($id);
        $data['status']          = $request->status;
        $data['is_active']        = $request->is_active;
        $testimonial->update($data);
        return redirect()->route('testimonials.testimonial.index')
            ->with('success_message', trans('testimonial.model_was_updated'));
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
        $testimonial           = Testimonial::with('user')->findOrFail($id);
        return view('testimonial.show', compact('testimonial'));
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

            return redirect()->route('testimonial.index')
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
                'status' => 'required',
                'is_active' => 'nullable'
            ];
        }

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }
}
