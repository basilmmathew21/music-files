<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\Student;
use App\Models\Classes;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sets the language.
     *
     */
    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $logged_in_id = auth()->user()->id;
        if ($request->ajax()) {
            /* $data = DB::table('payment_histories as p')
            ->join('students as s', 's.user_id', '=', 'p.student_user_id')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('tutors as t', 't.user_id', '=', 'p.tutor_user_id')
            ->join('users as us','t.user_id', '=', 'us.id')
            ->join('payment_methods as pm','p.payment_method_id','=','pm.id')
            ->join('currencies as c','p.currency_id','=','c.id')
            ->select('p.*','us.name as tutor_name','u.name as student_name','c.*','pm.payment_method')
            ->get();*/

            $data = DB::table('payment_histories as p')
                ->join('users as u', 'p.student_user_id', '=', 'u.id')
                ->leftjoin('payment_methods as pm', 'p.payment_method_id', '=', 'pm.id')
                ->select('p.*', 'u.name as student_name', 'pm.payment_method', DB::raw('DATE_FORMAT(p.payment_date, "%d-%b-%Y") as payment_date'));

            if (auth()->user()->roles[0]->id == 4) {
                $data = $data->where('p.student_user_id', $logged_in_id);
            }
            $data = $data->get();

            $datatable = DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['student_name'] . $row['tutor_name'] . $row['status']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }

                })
                ->addIndexColumn()
                ->addColumn('action', function ($payments) {
                    return view('paymenthistory.datatable', compact('payments'));
                })
                ->rawColumns(['action'])
                ->make(true);
            return $datatable;
        }
        $user = \Auth::user()->id;
        $user_data = DB::table('users')->select('*')->where('id', '=', $user)->first();
        if ($user_data->user_type_id == '4') {
            $payments = PaymentHistory::paginate(25);
            return view('paymenthistory.index-student', compact('payments'));
        } else {
            $payments = PaymentHistory::paginate(25);
            return view('paymenthistory.index', compact('payments'));
        }

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
        //$data = $request->all();
        $data = array();
        $data['student_user_id'] = '4';
        $data['tutor_user_id'] = '2';
        $data['fee_type'] = 'registration_fee';
        $data['payment_date'] = '2021-07-08 19:59:04';
        $data['currency_id'] = '1';
        $data['amount'] = '100.00';
        $data['no_of_classes'] = '12';
        $data['payment_method_id'] = '1';
        $data['status'] = 'pending';
        $data['created_at'] = '2021-07-08 19:59:04';
        $data['updated_at'] = '2021-07-08 19:59:04';

        PaymentHistory::create($data);
        return redirect()->route('payments.payments.index')
            ->with('success_message', trans('paymenthistory.model_was_added'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = DB::table('payment_histories as p')
            ->join('users as u', 'p.student_user_id', '=', 'u.id')
            ->leftjoin('payment_methods as pm', 'p.payment_method_id', '=', 'pm.id')
            ->join('currencies as c', 'p.currency_id', '=', 'c.id')
            ->select('p.*','c.*', 'u.name as student_name', 'pm.payment_method', 'p.id as main_id', DB::raw('DATE_FORMAT(p.payment_date, "%d-%b-%Y") as payment_date'))

            ->where('p.id', '=', $id)
            ->first();
        //echo '<pre>';print_r($payment);echo '</pre>';
        return view('paymenthistory.show', compact('payment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = DB::table('payment_histories as p')
            ->join('users as u', 'p.student_user_id', '=', 'u.id')
            ->leftjoin('payment_methods as pm', 'p.payment_method_id', '=', 'pm.id')
            ->join('currencies as c', 'p.currency_id', '=', 'c.id')
            ->select('p.*','c.symbol', 'u.name as student_name', 'pm.payment_method', 'p.id as main_id', DB::raw('DATE_FORMAT(p.payment_date, "%d-%b-%Y") as payment_date'))

            ->where('p.id', '=', $id)
            ->first();
        //echo '<pre>';print_r($payment);echo '</pre>';
        return view('paymenthistory.edit', compact('payment'));
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
        $pay        =   $request->all();
        $payment    =   PaymentHistory::find($id);
        $prevStatus =   $payment->status;
        $payment->update($pay);
        //status   1 - Pending , 2 - paid, 3 -failed
        //Failed status
        
        if($prevStatus == "paid" && ($request->status == "3" || $request->status = "1")){
           
           $studentDetais       =   Student::where('user_id', $payment->student_user_id)->first();
           $student['credits']  =   $studentDetais->credits - $payment->amount;
           $studentDetais->update($student);

           $paymentDetails   = User::Join('students', 'students.user_id', '=', 'users.id')
                                    ->Join('classes', 'students.user_id', '=', 'classes.student_user_id')
                                    ->select(['students.class_fee','classes.id as classIds'])
                                    ->where('classes.is_paid','1')
                                    ->where('users.id',$payment->student_user_id)
                                    ->orderBy('classes.id','desc')
                                    ->get();
            
            foreach($paymentDetails as $payInfo){
                if($studentDetais->credits <= 0)
                {
                    $classInfo                  = Classes::findOrFail($payInfo->classIds);
                    $paymentData['is_paid']     = 0;
                    $classInfo->update($paymentData);
                    $student['credits']         = $studentDetais->credits + $studentDetais->class_fee;
                    $studentDetais->update($student);
                }else{
                    break;
                }
            }
       }
       //Paid status
       if(($prevStatus == "failed" || $prevStatus == "pending") && $request->status == "2"){
                
            if($payment->student_user_id != null){
                $id     =   $payment->student_user_id;
            }
            
            $studentDetais   =   Student::where('user_id', $id)->first();
            $amountPay       =   $payment->amount;

            $student['credits']  =  $studentDetais->credits + $amountPay;
            $studentDetais->update($student);
            
            $paymentDetails   = User::Join('students', 'students.user_id', '=', 'users.id')
                                    ->Join('classes', 'students.user_id', '=', 'classes.student_user_id')
                                    ->select(['students.class_fee','classes.id as classIds'])
                                    ->where('classes.is_paid','0')
                                    ->where('users.id',$id)
                                    ->get();

            if(count($paymentDetails) != 0){
                foreach($paymentDetails as $payment){
                    if($student['credits'] >= $studentDetais->class_fee)
                    {
                        $classInfo               = Classes::findOrFail($payment['classIds']);
                        $paymentData['date']     = date("Y-m-d"); 
                        $paymentData['is_paid']  = 1;
                        $classInfo->update($paymentData);
                        $student['credits']      =  $studentDetais->credits - $studentDetais->class_fee;
                        $studentDetais->update($student);
                    }
                    else{
                        break;
                    }
                }
             }
        }
       
        // echo '<pre>';print_r($id);echo '</pre>';exit;
        return redirect()->route('payments.payments.index')
            ->with('success_message', trans('paymenthistory.model_was_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $payment = PaymentHistory::find($id);
            $payment->delete();

            return redirect()->route('payments.payments.index')
                ->with('success_message', trans('paymenthistory.model_was_deleted'));
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => trans('paymenthistory.unexpected_error')]);
        }
    }
}
