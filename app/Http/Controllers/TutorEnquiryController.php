<?php

namespace App\Http\Controllers;

use App\Models\TutorEnquiry;
use App\Models\User;
use App\Models\Country;
use App\Models\Settings;
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
                ->select(['tutor_enquiries.*', 'countries.name AS country_name', DB::raw('CONCAT(countries.phone_code," ",tutor_enquiries.phone) as phone')])
                ->orderBy('tutor_enquiries.created_at', 'desc')
                ->get();
                

            $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['phone'] . $row['email'] . $row['name']), Str::lower($request->get('keyword'))) ? true : false;
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

        $tutor = TutorEnquiry::orderBy('id','desc')->paginate(25);
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
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users|unique:tutor_enquiries',
            'phone' => 'required',
        ]);
        //dd($validatedData);
        if ($validatedData->fails()) {
            $error['errors'] = $validatedData->errors();
            return redirect()->back()->withInput()
                ->with($error);
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////
        //Check Phone number duplication 
        //users table
        $user_phone = User::where('phone', '=', $request->phone)
        ->orWhere('whatsapp_number', '=', $request->phone)->first();

        //tutor enquiry table
        $tutrenquiry_phone=TutorEnquiry::where('phone', '=', $request->phone)
        ->orWhere('whatsapp_number', '=', $request->phone)->first();


       if($user_phone) 
           $check_users_phone=1;
       else 
           $check_users_phone=0;

       if($tutrenquiry_phone) 
           $check_enquiry_phone=1;
       else 
           $check_enquiry_phone=0;

       if($check_users_phone==1 ||  $check_enquiry_phone==1)
       {
           return redirect()->back()->withInput()->withErrors("The Phone has already been taken.");
       }


         //Check Whatsapp number Duplication
         //users table
         $user_whatsapp = User::where('phone', '=', $request->whatsapp_number)
         ->orWhere('whatsapp_number', '=', $request->whatsapp_number)->first();

         //tutor enquiry table
         $tutrenquiry_whatsapp=TutorEnquiry::where('phone', '=', $request->whatsapp_number)
         ->orWhere('whatsapp_number', '=', $request->whatsapp_number)->first();


        if($user_whatsapp) 
            $check_users_whatsapp=1;
        else 
            $check_users_whatsapp=0;

        if($tutrenquiry_whatsapp) 
            $check_enquiry_whatsapp=1;
        else 
            $check_enquiry_whatsapp=0;

        if($check_users_whatsapp==1 ||  $check_enquiry_whatsapp==1)
        {
            return redirect()->back()->withInput()->withErrors("The Whatsapp Number has already been taken.");
        }

        /* if($request->has('image')){ 
                $flag = $request->file('image');
//dd($flag);
                $extension = $flag->getClientOriginalExtension();

                $flag->storeAs('/tutor-enquiry', uniqid().time().".".$extension);

                $name = uniqid().time().".".$extension;

                $data['profile_image'] = $name;
        } */
        $data['dob'] = date_format(date_create($data['dob']), 'Y-m-d');
        $data['date_of_enquiry'] = date('Y-m-d');
        TutorEnquiry::create($data);
        $country = Country::find($data['country_id']);


        $adminInfo =   Settings::find(3);

     
        $details = [
            'subject' => config('adminlte.title').' Tutor Enquiry',
            'content' =>  __('adminlte::adminlte.thankyou_tutor_enquiry')
        ];
        \Mail::to($data['email'])->send(new \App\Mail\TutorMail($details));


        $details = [
            'subject' => config('adminlte.title').' Tutor Enquiry',
            'content' =>  __('adminlte::adminlte.thankyou_tutor_admin_info')
        ];
        \Mail::to($adminInfo['value'])->send(new \App\Mail\TutorMail($details));

        /* Mail::send('emails.tutor-enquiry', ['data' => $data, 'admin' => $admin], function ($m) use ($data, $admin, $country) {
            $m->from($data['email'], 'Tutor Enquiry');
            if ($data['name'])
                $m->to($admin['email'], $data['name'])->subject('Tutor Enquiry From ' . $data['name']);
            else
                $m->to('admin@example.com')->subject('Tutor Enquiry');
        });
 */

       // return Redirect::to('thankyou')->with('success_message', "Registration Successful");;

        return redirect()->route('tutorenquiries.tutorenquiry.thankyou')
            ->with('success_message', trans('Tutor Enquiry Submitted Successfully'));
    }

    /**
     * Show the form for creating a new student.
     *
     * @return Illuminate\View\View
     */
    public function thankyou()
    {

        return view('thankyou.thankyou-tutor');
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
        $tutor = DB::table('tutor_enquiries')->where('tutor_enquiries.id', $id)
            ->leftJoin('countries', 'tutor_enquiries.country_id', '=', 'countries.id')
            ->select(['tutor_enquiries.*', 'countries.name AS country_name', 'tutor_enquiries.dob', DB::raw('DATE_FORMAT(tutor_enquiries.dob, "%d-%m-%y") as dob'), DB::raw('CONCAT(countries.phone_code," ",tutor_enquiries.phone) as phone'), DB::raw('CONCAT(countries.phone_code," ",tutor_enquiries.whatsapp_number) as whatsapp_number')])
            ->first();
        // 
        if ($tutor->status == 'new')
            $read = TutorEnquiry::where('id', $id)->update(['status' => 'read']);

        $tutor->teaching_stream = ($tutor->teaching_stream) ? $tutor->teaching_stream : '-';
        $tutor->educational_qualification = ($tutor->educational_qualification) ? $tutor->educational_qualification : '-';
        $tutor->teaching_experience = ($tutor->teaching_experience) ? $tutor->teaching_experience : '-';
        $tutor->performance_experience = ($tutor->performance_experience) ? $tutor->performance_experience : '-';
        $tutor->other_details = ($tutor->other_details) ? $tutor->other_details : '-';


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
