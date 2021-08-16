<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\PaymentHistory;
use DataTables;
use Illuminate\Support\Str;
use DB;


class PaymentdueController extends Controller
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
        if ($request->ajax()) { 
        $data =DB::table('classes as c')
        ->select('c.*','us.name as tutor_name','u.name as student_name','s.credits as credits', DB::raw('sum(c.class_fee) as sum_n'))
        ->groupBy('c.student_user_id')
        ->join('students as s', 's.user_id', '=', 'c.student_user_id')
        ->join('users as u', 's.user_id', '=', 'u.id')
        ->join('tutors as t', 't.user_id', '=', 'c.tutor_user_id')
        ->join('users as us','t.user_id', '=', 'us.id')
        ->where('c.is_paid','=','0')
        ->get();
        $datatable =  DataTables::of($data)
                ->filter(function ($instance) use ($request) {
                    if ($request->has('keyword') && $request->get('keyword')) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['student_name'] .$row['tutor_name']), Str::lower($request->get('keyword'))) ? true : false;
                        });
                    }
                    
                })
                ->addIndexColumn()
                ->addColumn('action', function ($payments) {
                    return view('paymentdue.datatable', compact('payments'));
                })
                ->rawColumns(['action'])
                ->make(true);
                return $datatable;
            }
        //$payments = DB::table('classes as c')
            // ->select('c.*','us.name as tutor_name','u.name as student_name','s.credits as credits', DB::raw('sum(c.class_fee) as sum_n'))
            // ->groupBy('c.student_user_id')
            // ->join('students as s', 's.user_id', '=', 'c.student_user_id')
            // ->join('users as u', 's.user_id', '=', 'u.id')
            // ->join('tutors as t', 't.user_id', '=', 'c.tutor_user_id')
            // ->join('users as us','t.user_id', '=', 'us.id')
            // ->where('c.is_paid','=','0')
            // ->get();
        $payments = Classes::select('*',DB::raw('sum(classes.class_fee) as sum_n'))->where('classes.is_paid','=','0')->groupBy('student_user_id')->join('students as s', 's.user_id', '=', 'classes.student_user_id')
        ->join('users as u', 's.user_id', '=', 'u.id')
        ->join('tutors as t', 't.user_id', '=', 'classes.tutor_user_id')
        ->join('users as us','t.user_id', '=', 'us.id')->get();
        //$payments = DB::select(DB::raw('select `c`.*, `us`.`name` as `tutor_name`, `u`.`name` as `student_name`, `s`.`credits` as `credits`, sum(c.class_fee) as sum_n from `classes` as `c` where is_paid = "0" inner join `students` as `s` on `s`.`user_id` = `c`.`student_user_id` inner join `users` as `u` on `s`.`user_id` = `u`.`id` inner join `tutors` as `t` on `t`.`user_id` = `c`.`tutor_user_id` inner join `users` as `us` on `t`.`user_id` = `us`.`id` group by `c`.`student_user_id`'));
            
        dd($payments);
        return view('paymentdue.index',compact('payments'));
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
        $data['status'] ='pending';
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
            ->join('students as s', 's.user_id', '=', 'p.student_user_id')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('tutors as t', 't.user_id', '=', 'p.tutor_user_id')
            ->join('users as us','t.user_id', '=', 'us.id')
            ->join('currencies as c','p.currency_id','=','c.id')
            ->join('payment_methods as pm','p.payment_method_id','=','pm.id')
            ->select('p.*','us.name as tutor_name','u.name as student_name','c.*','pm.payment_method','p.id as main_id')
            ->where('p.id','=', $id)
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
            ->join('students as s', 's.user_id', '=', 'p.student_user_id')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->join('tutors as t', 't.user_id', '=', 'p.tutor_user_id')
            ->join('users as us','t.user_id', '=', 'us.id')
            ->join('currencies as c','p.currency_id','=','c.id')
            ->join('payment_methods as pm','p.payment_method_id','=','pm.id')
            ->select('p.*','us.name as tutor_name','u.name as student_name','c.*','pm.payment_method')
            ->where('p.id','=', $id)
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
        $pay = $request->all();
        $payment = PaymentHistory::find($id);
        $payment->update($pay);
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
