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
       
              

              //////////////////////////////////////////////////////
              if ($request->ajax()) {           
                $data=DB::table('sms')
                ->select('sms.*','users.name')
                ->leftjoin('users','users.id','=','sms.from_user_id')
                ->where('to_user_id',  $log_user->id)
                ->orderby('sent_on','desc')->get();
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
       
              //////////////////////////////////////////////////////
              if ($request->ajax()) {           
                $data=DB::table('sms')
                ->select('sms.*','users.name')
                ->leftjoin('users','users.id','=','sms.to_user_id')
                ->where('from_user_id',  $log_user->id)
                ->orderby('sent_on','desc')->get();
               
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
            $whereIn=array('2','3','4');
            $users=DB::table('users')
            ->select('users.*')
            ->whereIn('user_type_id',$whereIn)
            ->where('is_active', 1)->get();


        }
        else if($log_user['user_type_id']==3)
        {
         
            $users=DB::table('users')
            ->select('users.*')
            ->leftjoin('tutor_students','tutor_students.user_id','=','users.id')
            ->where('tutor_students.tutor_id',$log_user['id'])
            ->where('users.is_active', 1)->get();

        } 
        else
        {
            $users=DB::table('users')
            ->select('users.*')
            ->leftjoin('tutor_students','tutor_students.tutor_id','=','users.id')
            ->where('tutor_students.user_id',$log_user['id'])
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
                ->select('sms.*','touser.name as toname','fromuser.name as fromname')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->where('to_user_type_id',  3)
                ->orderby('sent_on','desc')->get();

                foreach($data as $d)
                {
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
                ->select('sms.*','touser.name as toname','fromuser.name as fromname')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->where('from_user_type_id',  3)
                ->orderby('sent_on','desc')->get();

                foreach($data as $d)
                {
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
                ->select('sms.*','touser.name as toname','fromuser.name as fromname')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->where('to_user_type_id',  4)
                ->orderby('sent_on','desc')->get();

                foreach($data as $d)
                {
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
                ->select('sms.*','touser.name as toname','fromuser.name as fromname')
                ->leftjoin('users as touser','touser.id','=','sms.to_user_id')
                ->leftjoin('users as fromuser','fromuser.id','=','sms.from_user_id')
                ->where('from_user_type_id',  4)
                ->orderby('sent_on','desc')->get();

                foreach($data as $d)
                {
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
