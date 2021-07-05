<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TutorClass;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Carbon\Carbon;

class TutorClassController extends Controller
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
            $data = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')
                    ->select(['classes.*','users.name'])->get();

            $datatable = DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                  /*  if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }*/

                })
                ->addIndexColumn()
                ->addColumn('action', function ($student) {
                    return view('classes.datatable', compact('student'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }

        $classes = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')->paginate(25);
        //var_dump($classes);exit;
        return view('classes.index', compact('classes'));
    }


    /**
     * Display the specified class details.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $classes = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')
                 ->where('classes.id',$id)->first();
        
        return view('classes.show', compact('classes'));
    }

    /**
     * Show the form for creating a new class details.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a new CLASSES in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);
        $data['tutor_user_id'] = 3;
        $data['date'] = Carbon::createFromFormat('d-m-y',$request->date)->format('Y-m-d');
        $cls_id=TutorClass::create($data)->id;
        

        $files = $request->file('attachment');
        //var_dump($files);exit;
        if ($request->hasFile('attachment')) {
            $file_count=1;
            foreach ($files as $file) {
                $fileName = time().'-'.$file_count.'.'.$file->extension();  

   

                $file->move(public_path('uploads/files_'.$cls_id), $fileName);
                $file_count++;
            }
        }

        return redirect()->route('tutor.classes.index')
            ->with('success_message', trans('users.model_was_added'));
    }

    protected function getData(Request $request, $id = 0)
    {

        $rules = [
            'student_user_id' => 'required',
            'date' => 'required',
            'summary' => 'required',
        ];

        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = [
                'name' => 'required|string|min:1|max:255',
                'email' => [
                    'required',
                    'min:1',
                    'max:255',
                    Rule::unique('users')->ignore($id),
                ],
                'password' => 'nullable|string|min:1|max:255',
            ];
        }

        $data = $request->validate($rules);

        return $data;
    }


      /**
     * Remove the specified classes from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $user = TutorClass::findOrFail($id);
        
                $user->delete();
            

            return redirect()->route('tutor.classes.index')
                ->with('success_message', trans('users.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('users.unexpected_error')]);
        }
    }

}
