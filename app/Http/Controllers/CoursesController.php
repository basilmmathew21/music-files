<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use DataTables;
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {           

            $data = Courses::all();
            $datatable =  Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->has('keyword') && $request->get('keyword')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['course'], Str::lower($request->get('keyword'))) ? true : false;
                    });
                }
            })
          
                ->addIndexColumn()            
                       ->addColumn('action', function ($courses) {
                    return view('courses.datatable', compact('courses'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }
        

        $courses = Courses::paginate(25);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([

            'course'=>'required'
        ]);
        

        
        $course=new Courses();
        $course->course=$request['course'];
        $course->is_active=$request['status'];
        $course->save();
        return redirect()->route('courses.course.index')
        ->with('success_message', trans('users.course_was_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course=Courses::find($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $course=Courses::find($id);
        $course->course=$request['course'];
        $course->is_active=$request['status'];
        $course->save();
        return redirect()->route('courses.course.index')
        ->with('success_message', trans('users.course_was_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course=Courses::find($id);
        $course->delete();
        return redirect()->route('courses.course.index')
        ->with('success_message', trans('users.course_was_deleted'));
    }
}
