<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\Tutor;
use App\Models\User;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;



class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Tutor $Tutor)
    {
        $this->Tutor = $Tutor;
        
    }
    public function index(Request $request)
    {
       

        if ($request->ajax()) {
            $data  = DB::table('users')
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->select(['users.*','countries.name AS country_name',DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
            ->where('user_type_id', 3)
            ->get();
            foreach($data as $d)
            {
                if($d->is_active==1)
                    $d->status='Active';
                else
                    $d->status='InActive';
            }

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
                   return view('tutors.datatable', compact('tutor'));
               })
               ->rawColumns(['action'])
               ->make(true);
           //dd($datatable);
           return $datatable;
       }

       $tutor = User::paginate(25);
       return view('tutors.index', compact('tutor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nationalities = Country::pluck('name', 'id')->all();
        $currency = Currency::pluck('symbol', 'id')->all();
       $students=User::where('user_type_id',4)->pluck('name','id');
        return view('tutors.create', compact('nationalities','currency','students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'dob' => 'required|date',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|digits:10',
    
           ]);
           //Check Email Duplication
        $user_email = User::where('email', '=', $request->email)->first();
        if($user_email)
           $check_mail=1;
        else
            $check_mail=0;


        //Check Phone number Duplication
        $user_phone = User::where('phone', '=', $request->phone)->first();
        
        if($user_phone)
           $check_phone=1;
        else
            $check_phone=0;


        if($check_mail==1)
        {
            return redirect()->back()->withErrors("Email Already Exist");
        }
        else if($check_phone==1)
        {
            return redirect()->back()->withErrors("Phone Number Already Exist");
        }
        else
        {
            $fileNameToStore="";
            if ($request->hasFile('profile_image')) {
                $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $fileNameToStore = $filename. '_'. time().'.'.$extension;
                $request->file('profile_image')->storeAs('public/images/profile', $fileNameToStore);
               
                }
    
                $this->Tutor->addtutor($request, $fileNameToStore);
    
                $message = Lang::get("Tutor Succesfully Added");
                return redirect()->route('tutors.tutor.index')
                ->with('success_message', $message);
            
          

        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')->where('users.id',$id)
                    ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
                    ->select(['users.*','countries.name AS country_name','users.dob',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%y") as dob'),DB::raw('CONCAT(countries.code," ",users.phone) as phone')])
                    ->first();
                   // 
        $tutor = Tutor::where('user_id',$id)->get();
        if(count($tutor)>0)
        {
            foreach($tutor as $t)
            {
                $user->teaching_stream=($t->teaching_stream)?$t->teaching_stream:'-';
                $user->educational_qualification=($t->educational_qualification)?$t->educational_qualification:'-';
                $user->teaching_experience=($t->teaching_experience)?$t->teaching_experience:'-';
                $user->performance_experience=($t->performance_experience)?$t->performance_experience:'-';
                $user->other_details=($t->other_details)?$t->other_details:'-';
            }

        }
        else
        {
            $user->teaching_stream='-';
            $user->educational_qualification='-';
            $user->teaching_experience='-';
            $user->performance_experience='-';
            $user->other_details='-';

        }
        
        return view('tutors.show', compact('user','tutor'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
       // 
      
      
       $tutor=DB::table('tutors')
                 ->where('user_id', $id)->get();
        if(count( $tutor)==0)
            $tutor="";

        $nationalities = Country::pluck('name', 'id')->all();
        $students=User::where('user_type_id',4)->pluck('name','id');
        $Selectedstudents= DB::table('tutor_students')
        ->select('user_id') ->where('tutor_id', $id)->get();
        
        if(count($Selectedstudents)>0)
        {
            
            foreach($Selectedstudents as $key=>$value)
            $selected[]=$value->user_id;
           
        }
        else{
            $selected[]="";
        }
        return view('tutors.edit', compact('nationalities','students','user','selected','tutor'));
        
            
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestse
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'dob' => 'required|date',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|digits:10'
    
           ]);

           //Check Email Duplication
        $user = User::where('email', '=', $request->email)
                ->where('id','!=',$id)->first();
        if($user)
           $check_email=1;
        else
            $check_email=0;

            
        //Check Phone number Duplication
        $user_phone = User::where('phone', '=', $request->phone)->first();
        
        if($user_phone)
           $check_phone=1;
        else
            $check_phone=0;


        if($check_email==1)
        {
            return redirect()->back()->withErrors("Email Already Exist");
        }
        else if($check_phone==1)
        {
            return redirect()->back()->withErrors("Phone Number Already Exist");
        }
        else
        {
            $fileNameToStore="";
            if ($request->hasFile('profile_image')) {
                $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $fileNameToStore = $filename. '_'. time().'.'.$extension;
                $request->file('profile_image')->storeAs('public/images/profile', $fileNameToStore);
               
                }
    
                $this->Tutor->updatetutor($request, $fileNameToStore,$id);
    
                $message = Lang::get("Tutor Succesfully Updated");

                return redirect()->route('tutors.tutor.index')
                ->with('success_message', $message);
            
          

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::where('id', $id)->delete();
        $tutor=Tutor::where('user_id', $id)->delete();
        $tutor_students=DB::table('tutor_students')->where('tutor_id', $id)->delete();
        $message = Lang::get("Tutor Succesfully Deleted");
        return redirect()->route('tutors.tutor.index')
        ->with('success_message', $message);
    }
   
}
