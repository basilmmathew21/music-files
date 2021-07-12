<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Currency;
use App\Models\Student;
use App\Models\Classes;

use Illuminate\Http\Request;
use Exception;
use DataTables;
use DB;
use Auth;
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
        $user   = User::with('student')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->select(['users.*','students.class_fee','students.credits','students.is_active as is_active','currencies.code','currencies.symbol'])
        ->findOrFail($id);

        $payment   = User
         ::Join('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
        ->select(['classes.id as totalClass'])
        ->where('classes.is_paid','0')
        ->where('users.id',$id)
        ->count();
        
        return view('feepayment.index', compact('user','payment'));
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
        $data      = $this->getData($request, $id);
       
        $studentDetais    =  Student::where('user_id', $id)->first();
        /*
        if($studentDetais && $studentDetais != null){
            $student['credits']      =  $studentDetais->credits + $data['class_fee'];
           $studentDetais->update($student);
        }
        */
        $paymentDetails     = User
        ::Join('students', 'students.user_id', '=', 'users.id')
       ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
       ->select(['students.class_fee','classes.id as classIds'])
       ->where('classes.is_paid','0')
       ->where('users.id',$id)
       ->get();
       $amountPay   =   $request->class_fee;
       foreach($paymentDetails as $payment){
        $classInfo                  = Classes::findOrFail($payment['classIds']);
        $paymentData['date']        = date("Y-m-d"); 
        $paymentData['is_paid']     = 1;
        $amountPay  = $amountPay - $studentDetais['class_fee'];
        if(($amountPay >= $studentDetais->class_fee) ||  ($amountPay == 0)){
           $classInfo->update($paymentData);
            echo "<br>1";
            $student['credits']      =  $studentDetais->credits + $studentDetais['class_fee'];
            $studentDetais->update($student);
        }else if(($amountPay < $studentDetais->class_fee) &&  ($amountPay > 0)){
            echo "<br>2";
            $student['credits']      =  $studentDetais->credits + $amountPay;
            $studentDetais->update($student);
        }
       }
       
 
        return redirect()->route('feepayment.fee.index')
            ->with('success_message', trans('users.model_fee_updated'));
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
