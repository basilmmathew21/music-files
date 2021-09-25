<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use DataTables;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // 
        
        if ($request->ajax()) {           

            $data = Settings::orderBy('id','desc')->get();
            $datatable =  Datatables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->has('keyword') && $request->get('keyword')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains(Str::lower($row['name']), Str::lower($request->get('keyword'))) ? true : false;
                    });
                }
            })
          
                ->addIndexColumn()            
                       ->addColumn('action', function ($settings) {
                    return view('settings.datatable', compact('settings'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }
        

        $settings = Settings::orderBy('id','desc')->paginate(25);

        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $settings = Settings::findOrFail($id);

        return view('settings.edit', compact('settings'));
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
        $settings=Settings::find($id);
        $settings->name=$request['name'];
        $settings->value=$request['value'];
        $settings->save();
        return redirect()->route('settings.settings.index')
        ->with('success_message', trans('setting.model_was_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
