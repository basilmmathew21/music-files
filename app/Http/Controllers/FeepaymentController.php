<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Currency;
use App\Models\Student;
use App\Models\Classes;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Exception;
use DataTables;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FeepaymentController extends Controller
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
        $id     = Auth::user()->id;
        if(Session::get('user_id')){
            $id = Session::get('user_id');
            Session::forget('user_id');
        }
        $user   = User::with('student')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->select(['users.*','students.class_fee','students.credits','users.is_active as is_active','currencies.code','currencies.symbol'])
        ->findOrFail($id);

        $payment   = User
         ::Join('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
        ->select(['classes.id as totalClass'])
        ->where('classes.is_paid','0')
        ->where('users.id',$id)
        ->count();

        $students  = User::join('students','students.user_id','=','users.id')
        ->where('users.user_type_id',4)
        ->where('users.is_active',1)
        ->select('users.name','students.display_name','users.id')->get();
        
        foreach($students as $student)
        {
            $student['name']= $student['display_name']."(".$student['name'].")";
        }

        $isSuperAdmin       =   $user->hasRole('super-admin');
        return view('feepayment.index', compact('user','payment','students','isSuperAdmin'));
    }



    public function ajaxFeePayment(Request $request){

        $id     =   $request->input('student_user_id');
        $user   =   User::with('student')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->select(['users.*','students.class_fee','students.credits','users.is_active as is_active','currencies.code','currencies.symbol'])
        ->findOrFail($id);
        
        $payment   = User::Join('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
        ->select(['classes.id as totalClass'])
        ->where('classes.is_paid','0')
        ->where('users.id',$id)
        ->count();

        $arrayResponse  =   array('user' => $user,'payment' => $payment);
        echo json_encode($arrayResponse);
        die;

    }


    /**
     * Update the specified driver in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        if($request->student_user_id != null){
            $id     =   $request->student_user_id;
        }
       
        $data             = $this->getData($request, $id);
        $studentDetais    = Student::where('user_id', $id)->first();
        $paymentDetails   = User
        ::Join('students', 'students.user_id', '=', 'users.id')
       ->Join('classes', 'students.user_id', '=', 'classes.student_user_id')
       ->select(['students.class_fee','classes.id as classIds'])
       ->where('classes.is_paid','0')
       ->where('users.id',$id)
       ->get();
       
       $amountPay   =   $request->class_fee;
       if(count($paymentDetails) != 0){
           foreach($paymentDetails as $payment){
                $classInfo                  = Classes::findOrFail($payment['classIds']);
                $paymentData['date']        = date("Y-m-d"); 
                $paymentData['is_paid']     = 1;
                $amountPay  = $amountPay - $studentDetais['class_fee'];
                if(($amountPay >= $studentDetais->class_fee) ||  ($amountPay == 0)){
                $classInfo->update($paymentData);
                    $student['credits']      =  $studentDetais->credits - $studentDetais['class_fee'];
                    $studentDetais->update($student);

                    $data                       = array();
                    $data['student_user_id']    = $id;
                    $data['tutor_user_id']      = $classInfo->tutor_user_id;
                    $data['fee_type']           = 'class_fee';
                    if($request->student_user_id != null){
                        $data['fee_type']       = 'admin';
                    }
                    $data['payment_date']       = date("Y-m-d H:i:s");
                    $data['currency_id']        = $studentDetais->currency_id;
                    $data['amount']             = $studentDetais['class_fee'];
                    $data['no_of_classes']      = $request->no_of_classes;
                    $data['payment_method_id']  = '1';
                    $data['status']             ='paid';
                    PaymentHistory::create($data);
                }
            }
            if($amountPay > 0){
                $student['credits']         =  $studentDetais->credits + $amountPay;
                $studentDetais->update($student);

                $data                       = array();
                $data['student_user_id']    = $id;
                $data['tutor_user_id']      = 0;
                $data['fee_type']           = 'class_fee';
                if($request->student_user_id != null){
                    $data['fee_type']       = 'admin';
                }
                $data['payment_date']       = date("Y-m-d H:i:s");
                $data['currency_id']        = $studentDetais->currency_id;
                $data['amount']             = $amountPay;
                $data['no_of_classes']      = $request->no_of_classes;
                $data['payment_method_id']  = '1';
                $data['status']             ='paid';
                PaymentHistory::create($data);
            }
        }else{
            if($studentDetais && $studentDetais != null){
               $student['credits']      =  $studentDetais->credits + $data['class_fee'];
               $studentDetais->update($student);

               $data                       = array();
               $data['student_user_id']    = $id;
               $data['tutor_user_id']      = 0;
               $data['fee_type']           = 'class_fee';
               if($request->student_user_id != null){
                $data['fee_type']       = 'admin';
               }
               $data['payment_date']       = date("Y-m-d H:i:s");
               $data['currency_id']        = $studentDetais->currency_id;
               $data['amount']             = $request->class_fee;
               $data['no_of_classes']      = $request->no_of_classes;
               $data['payment_method_id']  = '1';
               $data['status']             ='paid';
               PaymentHistory::create($data);
            }
        }
       
 
        return redirect()->route('feepayment.fee.index')
            ->with(['success_message' => trans('users.model_fee_updated'),'user_id' => $id]);
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request, $id = 0)
    {
        //Validating unique for update ignoring the same record
        if ($id) {
            $rules = [
                'class_fee' => "required|regex:/^\d+(\.\d{1,2})?$/",
            ];
        }
        
        $data = $request->validate($rules);
        return $data;
    }
}
