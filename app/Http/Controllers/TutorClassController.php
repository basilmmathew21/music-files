<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TutorClass;
use App\Models\User;
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

         $logged_in_id = auth()->user()->id;

        if ($request->ajax()) {
            $data = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id');

            if (auth()->user()->roles[0]->id == 3)
        {
            $data = $data->where('tutor_user_id',$logged_in_id);
        }
        $data = $data->select(['classes.*','users.name',DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')])->get();

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

        $path = public_path('uploads/files_'.$id);

        $files=array();
        if (is_dir($path)) {
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
  
        //print_r($files);exit;
        }
  
  
        $classes = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')
                 ->where('classes.id',$id)->select(['classes.*','users.name',DB::raw('DATE_FORMAT(classes.date, "%d-%b-%Y") as date')])->first();
        
        return view('classes.show', compact('classes','files'));
    }

    /**
     * Show the form for creating a new class details.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
       
        $students  = User::where('user_type_id',4)->pluck('name', 'id');
        $tutors  = User::where('user_type_id',3)->pluck('name', 'id');
        if (auth()->user()->roles[0]->id != 3)
        {
            $students=array();  
        }
        //echo '<pre>';print_r($students);exit;
        return view('classes.create',compact('students','tutors'));
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
        $data['tutor_user_id'] = auth()->user()->id;

        if (auth()->user()->roles[0]->id != 3)
        {
            $data['tutor_user_id'] = $request->input('tutor_user_id');
        }

        $student = Student::where('user_id',$data['student_user_id'])->first();
       /*  if ($student->credits>=$student->class_fee){ //Automatically pay with the credits
            $data['is_paid'] = 1;
            $student->credits = $student->credits - $student->class_fee;
            $student->save();
        } */
        
        $data['currency_id'] = $student->currency_id;
        $data['class_fee'] = $student->class_fee;
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


     /**
     * Show the form for editing the specified classes.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $classes = TutorClass::leftJoin('users', 'classes.student_user_id', '=', 'users.id')
        ->where('classes.id',$id)->select(['classes.*','users.name',DB::raw('DATE_FORMAT(classes.date, "%d-%m-%y") as date')])->first();

        $path = public_path('uploads/files_'.$id);

        $files=array();
        if (is_dir($path)) {
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
  
        //print_r($files);exit;
        }

      
        $tutors  = User::where('user_type_id',3)->pluck('name', 'id');

        $students  = User::join('tutor_students as ts','ts.user_id','=','users.id')
        ->where('users.user_type_id',4)->where('ts.tutor_id',$classes->tutor_user_id)
        ->pluck('users.name', 'users.id')->all();

        return view('classes.edit', compact('classes','files','students','tutors'));
    }

    /**
     * Update the specified classes in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request, $id);
        if (auth()->user()->roles[0]->id != 3)
        {
            $data['tutor_user_id'] = $request->input('tutor_user_id');
        }
        
        $user = TutorClass::findOrFail($id);

        $data['date'] = Carbon::createFromFormat('d-m-y',$request->date)->format('Y-m-d');
       
        $user->update($data);

        $files = $request->file('attachment');
        //var_dump($files);exit;
        if ($request->hasFile('attachment')) {
            $file_count=1;
            foreach ($files as $file) {
                $fileName = time().'-'.$file_count.'.'.$file->extension();  

   

                $file->move(public_path('uploads/files_'.$id), $fileName);
                $file_count++;
            }
        }

        return redirect()->route('tutor.classes.index')
            ->with('success_message', trans('classes.model_was_updated'));
    }

    protected function getData(Request $request, $id = 0)
    {

        $rules = [
            'student_user_id' => 'required',
            'date' => 'required',
            'summary' => 'required',
        ];

    

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
                ->with('success_message', trans('classes.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('classes.unexpected_error')]);
        }
    }


    public function removeFile(Request $request)
    {
        $file=$request->input('file');
        unlink($file);
    }

    public function ajaxTutorStudents(Request $request){

        $tutor_id=$request->input('tutor_id');

        $students  = User::join('tutor_students as ts','ts.user_id','=','users.id')
        ->where('users.user_type_id',4)->where('ts.tutor_id',$tutor_id)
        ->select(['users.name', 'users.id'])->get();

        echo json_encode($students);exit;

    }

}
