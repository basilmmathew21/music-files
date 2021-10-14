<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DataTables;
use DB;

use App\Models\Sms;
use App\Models\User;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function inbox(Request $request)
    {
              $log_user=auth()->user();       
              $user_type=User::where('id',$log_user->id)->pluck('user_type_id')->first();
             
              //////////////////////////////////////////////////////
              if ($request->ajax()) {    
                  if($user_type==3) 
                  {
                    $data=SMS::select("sms.*",
                                 \DB::raw('(CASE 
                                WHEN users.user_type_id = "4" THEN students.display_name 
                                ELSE users.name  END) AS name'))
                                ->leftjoin('users','users.id','=','sms.from_user_id') 
                                ->leftjoin('students','students.user_id','=','sms.from_user_id')                
                                ->where('to_user_id',  $log_user->id)
                                ->orderby('sent_on','desc')->get();

                  }  
                  else  if($user_type==4)   
                  {
                    $data=SMS::select('sms.*', \DB::raw('(CASE 
                                WHEN users.user_type_id = "3" THEN tutors.display_name 
                                ELSE users.name  END) AS name'))
                                ->leftjoin('users','users.id','=','sms.from_user_id')  
                                ->leftjoin('tutors','tutors.user_id','=','sms.from_user_id')               
                                ->where('to_user_id',  $log_user->id)
                                ->orderby('sent_on','desc')->get();

                  } 
                  else
                  {
                    $data=SMS::select('sms.*','users.name',\DB::raw('(CASE 
                                WHEN users.user_type_id = "3" THEN tutors.display_name
                                WHEN users.user_type_id = "4" THEN students.display_name 
                                ELSE users.name  END) AS display_name'))
                                ->leftjoin('users','users.id','=','sms.from_user_id') 
                                ->leftjoin('students','students.user_id','=','sms.from_user_id') 
                                ->leftjoin('tutors','tutors.user_id','=','sms.from_user_id')                
                                ->where('to_user_id',  $log_user->id)
                                ->orderby('sent_on','desc')->get();
                    
                    foreach($data as $d)
                    {
                        $d['name']=$d['display_name']."(".$d['name'].")";
      
                    }
                    

                  }
              
                foreach($data as $d)
                {
                    if(strlen($d->message)>20)                    
                       $d->message=substr($d->message, 0, 20)."...";                    

                 }
               
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.inbox', compact('sms'));

    }
    public function sent(Request $request)
    {
        $log_user=auth()->user();
        $user_type=User::where('id',$log_user->id)->pluck('user_type_id')->first();
       
              //////////////////////////////////////////////////////
              if ($request->ajax()) {           
               /* $data=DB::table('sms')
                ->select('sms.*','users.name')
                ->leftjoin('users','users.id','=','sms.to_user_id')
                ->where('from_user_id',  $log_user->id)
                ->orderby('sent_on','desc')->get();*/

                if($user_type==3) 
                {
                  $data=SMS::select("sms.*",
                               \DB::raw('(CASE 
                              WHEN users.user_type_id = "4" THEN students.display_name 
                              ELSE users.name  END) AS name'))
                              ->leftjoin('users','users.id','=','sms.to_user_id') 
                              ->leftjoin('students','students.user_id','=','sms.to_user_id')                
                              ->where('from_user_id',  $log_user->id)
                              ->orderby('sent_on','desc')->get();

                }  
                else  if($user_type==4)   
                {
                  $data=SMS::select('sms.*', \DB::raw('(CASE 
                              WHEN users.user_type_id = "3" THEN tutors.display_name 
                              ELSE users.name  END) AS name'))
                              ->leftjoin('users','users.id','=','sms.to_user_id')  
                              ->leftjoin('tutors','tutors.user_id','=','sms.to_user_id')               
                              ->where('from_user_id',  $log_user->id)
                              ->orderby('sent_on','desc')->get();

                } 
                else
                {
                  $data=SMS::select('sms.*','users.name',\DB::raw('(CASE 
                              WHEN users.user_type_id = "3" THEN tutors.display_name
                              WHEN users.user_type_id = "4" THEN students.display_name 
                              ELSE users.name  END) AS display_name'))
                              ->leftjoin('users','users.id','=','sms.to_user_id') 
                              ->leftjoin('students','students.user_id','=','sms.to_user_id') 
                              ->leftjoin('tutors','tutors.user_id','=','sms.to_user_id')                
                              ->where('from_user_id',  $log_user->id)
                              ->orderby('sent_on','desc')->get();
                  
                  foreach($data as $d)
                  {
                      $d['name']=$d['display_name']."(".$d['name'].")";
    
                  }
                }
               
                foreach($data as $d)
                 {
                     if(strlen($d->message)>20)                    
                        $d->message=substr($d->message, 0, 20)."...";  
                    

                  }
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.sent', compact('sms'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compose()
    {
        $log_user=auth()->user();
        if($log_user['user_type_id']==1 || $log_user['user_type_id']==2)
        {
            
            $users=DB::table('users')
            ->select('users.*')
            ->where('user_type_id','!=',1)
            ->where('is_active', 1)->get();

            $users=User::select('users.*',\DB::raw('(CASE 
                                WHEN users.user_type_id = "3" THEN tutors.display_name
                                WHEN users.user_type_id = "4" THEN students.display_name 
                                ELSE users.name  END) AS display_name'))
                                ->leftjoin('students','students.user_id','=','users.id') 
                                ->leftjoin('tutors','tutors.user_id','=','users.id')                
                                ->where('user_type_id','!=',1)
                                ->where('is_active', 1)
                                ->orderBy('users.created_at')->get();
                foreach($users as $user)
                {
                    if($user->display_name!='Admin')
                        $user->display_name=$user->display_name."(".$user->name.")";

                }


        }
        else if($log_user['user_type_id']==3)
        {
         
            $users=DB::table('users')
            ->select('users.*','students.display_name')
            ->leftjoin('tutor_students','tutor_students.user_id','=','users.id')
            ->leftjoin('students','students.user_id','=','tutor_students.user_id')
            ->where('tutor_students.tutor_id',$log_user['id'])
            ->orWhere('users.user_type_id',1)
            ->where('users.is_active', 1)->get();

        } 
        else
        {
            $users=DB::table('users')
            ->select('users.*','tutors.display_name')
            ->leftjoin('tutor_students','tutor_students.tutor_id','=','users.id')
            ->leftjoin('tutors','tutors.user_id','=','tutor_students.tutor_id')
            ->where('tutor_students.user_id',$log_user['id'])
            ->orWhere('users.user_type_id',1)
            ->where('users.is_active', 1)->get();

        }

           
      
        return view('sms.compose',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addmessage(Request $request)
    {
        $to_user=User::find($request['to_user']);
        $from_user=$request->user(); 
        if($to_user)
        {
            $sms=new Sms();
            $sms->from_user_id=$from_user['id'];
            $sms->to_user_id=$request['to_user'];
            $sms->message=$request['message'];
            $sms->from_user_type_id=$from_user['user_type_id'];
            $sms->to_user_type_id=$to_user['user_type_id'];
            $sms->to_phone=$to_user['phone'];
            $sms->sent_on=date('Y-m-d H:i:s');
            $sms->status='sent';
            $sms->save();

          //Send Mail to Rcepient

            $details = [
                'content' =>   "You have a new Message from ".$from_user['name'],
                'toname'    =>    $to_user['name'],
                'fromname'    =>    $from_user['name'],
                'message'    =>    $request['message'],
                'email'   =>    $to_user['email'],
                'login'   =>    true
            ];
            \Mail::to($to_user['email'])->send(new \App\Mail\SmsMail($details));
        }
        return redirect()->back()
        ->with('success_message', trans('Message Sent'));
    }

    public function tutor_inbox(Request $request)
    {
        $log_user=auth()->user();
       
            
              //////////////////////////////////////////////////////
              if ($request->ajax()) {           
                $data=DB::table('sms')
                        ->select('sms.*','touser.name as toname','fromuser.name as fromname','students.display_name as student_displayname','tutors.display_name as tutor_displayname','touser.user_type_id as to_user_type_id','fromuser.user_type_id as from_user_type_id')
                        ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                        ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                        ->leftjoin('students','students.user_id','=','sms.from_user_id') 
                        ->leftjoin('tutors','tutors.user_id','=','sms.to_user_id')   
                        ->where('to_user_type_id',  3)
                        ->orderby('sent_on','desc')->get();
                foreach($data as $d)
                {
                    if($d->fromname!='Super Admin')
                        $d->fromname=$d->student_displayname."(".$d->fromname.")";
                    $d->toname=$d->tutor_displayname."(".$d->toname.")";
                    if(strlen($d->message)>20)                    
                       $d->message=substr($d->message, 0, 20)."...";                    

                 }
               
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['fromname'] . $row['toname'] ), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.tutor_inbox', compact('sms'));


    }
    public function tutor_sent(Request $request)
    {
        $log_user=auth()->user();
       
              //////////////////////////////////////////////////////
              if ($request->ajax()) {           
                $data=DB::table('sms')
                ->select('sms.*','touser.name as toname','fromuser.name as fromname','students.display_name as student_displayname','tutors.display_name as tutor_displayname','touser.user_type_id as to_user_type_id','fromuser.user_type_id as from_user_type_id')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->leftjoin('students','students.user_id','=','sms.to_user_id') 
                ->leftjoin('tutors','tutors.user_id','=','sms.from_user_id')   
                ->where('from_user_type_id',  3)
                ->orderby('sent_on','desc')->get();
                foreach($data as $d)
                {
                    if($d->toname!='Super Admin')
                        $d->toname=$d->student_displayname."(".$d->toname.")";
                    $d->fromname=$d->tutor_displayname."(".$d->fromname.")";
                    if(strlen($d->message)>20)                    
                    $d->message=substr($d->message, 0, 20)."...";                    

                }

              
               
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['fromname'] . $row['toname'] ), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.tutor_sent', compact('sms'));
    }
    public function student_inbox(Request $request)
    {
        $log_user=auth()->user();
       
              //////////////////////////////////////////////////////
              if ($request->ajax()) {  
                $data=DB::table('sms')
                ->select('sms.*','touser.name as toname','fromuser.name as fromname','students.display_name as student_displayname','tutors.display_name as tutor_displayname','touser.user_type_id as to_user_type_id','fromuser.user_type_id as from_user_type_id')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->leftjoin('students','students.user_id','=','sms.to_user_id') 
                ->leftjoin('tutors','tutors.user_id','=','sms.from_user_id')   
                ->where('to_user_type_id',  4)
                ->orderby('sent_on','desc')->get();
                foreach($data as $d)
                {
                    if($d->fromname!='Super Admin')
                        $d->fromname=$d->tutor_displayname."(".$d->fromname.")";
                    $d->toname=$d->student_displayname."(".$d->toname.")";
                    if(strlen($d->message)>20)                    
                    $d->message=substr($d->message, 0, 20)."...";                    

                }         
              
               
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['fromname'] . $row['toname'] ), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.student_inbox', compact('sms'));


    }
    public function student_sent(Request $request)
    {
        $log_user=auth()->user();
       
              //////////////////////////////////////////////////////
              if ($request->ajax()) {  
                $data=DB::table('sms')
                ->select('sms.*','touser.name as toname','fromuser.name as fromname','students.display_name as student_displayname','tutors.display_name as tutor_displayname','touser.user_type_id as to_user_type_id','fromuser.user_type_id as from_user_type_id')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->leftjoin('students','students.user_id','=','sms.from_user_id') 
                ->leftjoin('tutors','tutors.user_id','=','sms.to_user_id')   
                ->where('from_user_type_id',  4)
                ->orderby('sent_on','desc')->get();
                foreach($data as $d)
                {
                    if($d->toname!='Super Admin')
                        $d->toname=$d->tutor_displayname."(".$d->toname.")";
                    $d->fromname=$d->student_displayname."(".$d->fromname.")";
                    if(strlen($d->message)>20)                    
                    $d->message=substr($d->message, 0, 20)."...";                    

                }      
                

                
                $datatable =  Datatables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['fromname'] . $row['toname'] ), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                })
              
                    ->addIndexColumn()            
                           ->addColumn('action', function ($sms) {
                        return view('sms.datatable', compact('sms'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                return $datatable;
            }
            
    
            $sms = Sms::paginate(25);
    
            return view('sms.student_sent', compact('sms'));







              /////////////////////////////////////////////////////
       // return view('sms.inbox',compact('sms'));
    }
   
    public function view_message($message_id)
    {
        $message=DB::table('sms')
        ->select('sms.*','touser.name as toname','fromuser.name as fromname')
        ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
        ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
        ->where('sms.id',$message_id)
        ->get()->first();
        return view('sms.viewmessage',compact('message'));
    }
   public function delete_message($message_id)
   {
    $message=Sms::find($message_id);
    $message->delete();
    return redirect()->back()
    ->with('success_message', trans('Message Deleted'));
   }
}
