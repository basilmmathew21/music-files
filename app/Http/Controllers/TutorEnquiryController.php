<?php

namespace App\Http\Controllers;
use App\Models\TutorEnquiry;
use App\Models\User;
use App\Models\Country;
use DataTables;
use DB;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class TutorEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(TutorEnquiry $TutorEnquiry)
    {
        $this->TutorEnquiry = $TutorEnquiry;
        
    }
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data  = DB::table('tutor_enquiries')
            ->join('countries', 'tutor_enquiries.country_id', '=', 'countries.id')
            ->select(['tutor_enquiries.*','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",tutor_enquiries.phone) as phone')])
            ->get();
           

           $datatable =  DataTables::of($data)
               ->filter(function ($instance) use ($request) {
                   if ($request->has('keyword') && $request->get('keyword')) {
                       $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name'] ), Str::lower($request->get('keyword'))) ? true : false;
                       });
                   }
                  
               })
               ->addIndexColumn()
               ->addColumn('action', function ($tutor) {
                   return view('tutor_enquiry.datatable', compact('tutor'));
               })
               ->rawColumns(['action'])
               ->make(true);
           //dd($datatable);
           return $datatable;
       }

       $tutor = TutorEnquiry::paginate(25);
       return view('tutor_enquiry.index', compact('tutor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view('tutor_enquiry.create', compact('country'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:tutor_enquiries',
            'phone' => 'required|digits:10',
        ]);
        //dd($validatedData);
        if ($validatedData->fails()) {
            $error['errors'] = $validatedData->errors();
            return redirect()->route('tutorenquiries.tutorenquiry.create')
            ->with($error);
        }

        if($request->has('image')){ 
                $flag = $request->file('image');
//dd($flag);
                $extension = $flag->getClientOriginalExtension();

                $flag->storeAs('/tutor-enquiry', uniqid().time().".".$extension);

                $name = uniqid().time().".".$extension;

                $data['profile_image'] = $name;
        }
        $data['dob'] = date_format(date_create($data['dob']),'Y-m-d');
        $data['date_of_enquiry'] = date('Y-m-d');
        TutorEnquiry::create($data);
        $admin = User::find('2');
        $country = Country::find($data['country_id']);
        Mail::send('emails.tutor-enquiry', ['data' => $data,'admin' => $admin], function ($m) use ($data,$admin,$country) {
                $m->from($data['email'], 'Contact Mail');
                if($data['name'])$m->to($admin['email'], $data['name'])->subject('Contact Mail From '.$data['name']);
                else $m->to('admin@example.com')->subject('Contact Mail');
        });

        return redirect()->route('tutorenquiries.tutorenquiry.create')
            ->with('success_message', trans('Tutor Enquiry Submitted Successfully'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
       
       $this->TutorEnquiry->accept_register($id);
      return redirect()->route('tutorenquiries.tutorenquiry.index')
       ->with('success_message', 'Enquiry Accepted');
    }
    public function reject($id)
    {
       
       $this->TutorEnquiry->reject_enquiry($id);
      return redirect()->route('tutorenquiries.tutorenquiry.index')
       ->with('success_message', 'Enquiry Rejected');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutor = DB::table('tutor_enquiries')->where('tutor_enquiries.id',$id)
        ->leftJoin('countries', 'tutor_enquiries.country_id', '=', 'countries.id')
        ->select(['tutor_enquiries.*','countries.name AS country_name','tutor_enquiries.dob',DB::raw('DATE_FORMAT(tutor_enquiries.dob, "%d-%m-%y") as dob'),DB::raw('CONCAT(countries.code," ",tutor_enquiries.phone) as phone')])
        ->first();
       // 
       if($tutor->status=='new')
            $read= TutorEnquiry::where('id', $id)->update(['status' => 'read']);
       
        $tutor->teaching_stream=($tutor->teaching_stream)?$tutor->teaching_stream:'-';
        $tutor->educational_qualification=($tutor->educational_qualification)?$tutor->educational_qualification:'-';
        $tutor->teaching_experience=($tutor->teaching_experience)?$tutor->teaching_experience:'-';
        $tutor->performance_experience=($tutor->performance_experience)?$tutor->performance_experience:'-';
        $tutor->other_details=($tutor->other_details)?$tutor->other_details:'-';
            

        return view('tutor_enquiry.show', compact('tutor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
