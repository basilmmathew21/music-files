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
use Razorpay\Api\Api;

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
        $id             = Auth::user()->id;
        $selectedUser   = false;
        if(Session::get('user_id')){
            $id             = Session::get('user_id');
            $selectedUser   = Session::get('user_id');  
            Session::forget('user_id');
        }
        $user   = User::with('student')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->select(['users.*','students.class_fee','students.credits','students.mode_of_remittance','users.is_active as is_active','currencies.code','currencies.symbol'])
        ->findOrFail($id);

        $payment   = User
         ::Join('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
        ->select(['classes.id as totalClass'])
        ->where('classes.is_paid','0')
        ->where('users.id',$id)
        ->sum('classes.class_fee');

        $students  = User::join('students','students.user_id','=','users.id')
        ->where('users.user_type_id',4)
        ->where('users.is_active',1)
        ->select('users.name','students.display_name','users.id')->get();
        
        foreach($students as $student)
        {
            $student['name']= $student['display_name']."(".$student['name'].")";
        }
        $logUser            =   Auth::user();
        $isSuperAdmin       =   $logUser->hasRole('super-admin');
        if($isSuperAdmin){
            return view('feepayment.index_admin', compact('user','payment','students','isSuperAdmin','id','selectedUser'));
        }
        return view('feepayment.index', compact('user','payment','students','isSuperAdmin'));
    }
    
    public function ajaxFeePaymentOrder(Request $request){
		$id             		= 	Auth::user()->id;
		$user   				= 	Auth::user();
        $chcktmpId				=	"class-fees".time();

		$currency_id            =   DB::table('students')->select('currency_id','country_id')->where('user_id',$id) ->get()->first();
		$country				=   DB::table('countries')->select('phone_code')->where('id',$currency_id->country_id) ->get()->first();
		$currency_code          =   DB::table('currencies')->select('code')->where('id',$currency_id->currency_id) ->get()->first();
        $student_currency       =   $currency_code->code;
		$student 				= 	Student::where('user_id',$id)->first();
		$amount					=	$request->class_fee*100;
		if($student_currency != "INR"){
		    $request_data = file_get_contents('https://data.fixer.io/api/convert?access_key=0d0b39254cefb941a64f7838ba522781&from='.$student_currency.'&to=INR&amount=1');
            $str  = json_decode($request_data);
            if($str->success){
                $student_currency = "INR";
                $amount					=	round(($str->result)*($request->class_fee)*100);
            }else{
                echo "Invalid Currency";exit;
            }
		}
		
		///print_r($amount);exit;
		$api = new Api(config('razorpay.key'), config('razorpay.secret'));
		$notes = array("StdentName"=>$student->display_name);
		$account_id = "";
		if($student->mode_of_remittance == "Indian"){
		    $account_id = config('razorpay.Indian');
		}
		elseif($student->mode_of_remittance == "International"){
		    $account_id = config('razorpay.International');
		}else{
		    $account_id = "";
		}
		
		//echo $account_id;exit;
		
		if($account_id){
            $order = $api->order->create(array('receipt' => $chcktmpId,  'amount' => $amount,  'currency' => $student_currency,'payment_capture' => 0,'transfers' => array(array('account' => 'acc_IPhUlrf90z5WzU','amount' =>  $amount,'currency' => $student_currency,'notes' => $notes,'linked_account_notes' => array('StdentName'),'on_hold' => 0))));
        }else{
		    $order = $api->order->create(array(  'receipt' => $chcktmpId,  'amount' => $amount,  'currency' => $student_currency,'payment_capture' => 0  ));
        }
		
		//print_r($order);exit;

		DB::table('razorpay_response')->insert(array("tmp_id"=>$chcktmpId,'user_id'=>$id,"razopay_order_id"=>$order['id'])) ;
		//print_r($order);exit;
		$razorpayOrderId = $order['id'];
				
		$data = [
			"key"               => 	config('razorpay.key'),
			"name"              => 	$student->display_name,
			"amount"            =>  $amount,
			"name"              =>  $student->display_name,
			"description"       =>  "Class (".$request->no_of_classes.") Fees",
			"image"             => 	"https://classes.musicshikshan.com/vendor/adminlte/dist/img/musicshikshanLogo.png",
			"prefill"           => 	[
				"name"              => $student->display_name,
				"email"             => $user->email,
				"contact"			=> $country->phone_code.$user->phone
			],
			"notes"             => [
				"merchant_order_id" => $chcktmpId,
			],
		   
			"theme"             => [
				"color"             => "#CB3727"
			],
			"order_id"          => $razorpayOrderId
		];
		return response()->json($data);
    }


    public function ajaxFeePayment(Request $request){

        $id     =   $request->input('student_user_id');
        $user   =   User::with('student')
        ->leftJoin('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('currencies', 'students.currency_id', '=', 'currencies.id')
        ->select(['users.*','students.class_fee','students.credits','students.mode_of_remittance','users.is_active as is_active','currencies.code','currencies.symbol'])
        ->findOrFail($id);
        
        $payment   = User::Join('students', 'students.user_id', '=', 'users.id')
        ->leftJoin('classes', 'students.user_id', '=', 'classes.student_user_id')
        ->select(['classes.id as totalClass'])
        ->where('classes.is_paid','0')
        ->where('users.id',$id)
        ->sum('classes.class_fee');

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
        $data                =  $this->getData($request, $id);
        $studentDetais       =  Student::where('user_id', $id)->first();
        $amountPay           =  $request->class_fee;
        $student['credits']  =  $studentDetais->credits + $amountPay;
        $studentDetais->update($student);
        $this->updatePaymentHistory($id,$studentDetais,$request);
        
        $paymentDetails   = User::Join('students', 'students.user_id', '=', 'users.id')
                                ->Join('classes', 'students.user_id', '=', 'classes.student_user_id')
                                ->select(['students.class_fee','classes.id as classIds'])
                                ->where('classes.is_paid','0')
                                ->where('users.id',$id)
                                ->orderBy('classes.id','asc')
                                ->get();
       
       if(count($paymentDetails) != 0){
          foreach($paymentDetails as $payment){
                if($student['credits'] > 0)
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
      
 
        return redirect()->route('feepayment.fee.index')
            ->with(['success_message' => trans('users.model_fee_updated'),'user_id' => $id]);
    }



    private function updatePaymentHistory($id,$studentDetais,$request)
    {
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
    public function razorpayVerifyPayment(Request $request)
    {
        
        
        $input = $request->all();
        
        //print_r($input);exit;
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);
		
		if (empty($request->razorpay_payment_id) === false)
		{
			$dt = DB::table('razorpay_response')->where("tmp_id",$request->order_id)->orderBy("id","desc")->first();
			
			$api = new Api(config('razorpay.key'), config('razorpay.secret'));
			try
			{
				// Please note that the razorpay order ID must
				// come from a trusted source (session here, but
				// could be database or something else)
				$attributes = array(
					'razorpay_order_id' => $dt->razopay_order_id,
					'razorpay_payment_id' => $request->razorpay_payment_id,
					'razorpay_signature' => $request->razorpay_signature
				);
				$api->utility->verifyPaymentSignature($attributes);
				if(count($input)  && !empty($input['razorpay_payment_id'])) {
					//try {
						
						$response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
						
						/*print_r(array('transfers' => array('account'=> 'acc_IPhZPn0FVI5346', 'amount'=> $payment['amount'], 'currency'=>'INR', 'notes'=> array('name'=>'Gaurav Kumar', 'roll_no'=>'IEC2011025'), 'linked_account_notes'=>array('branch'), 'on_hold'=>'1', 'on_hold_until'=>'1671222870')));
						
						
						$response1 = $api->payment->fetch($input['razorpay_payment_id'])->transfer(array('transfers' => array('account'=> 'acc_IPhZPn0FVI5346', 'amount'=> $payment['amount'], 'currency'=>'INR', 'notes'=> array('name'=>'Gaurav Kumar', 'roll_no'=>'IEC2011025'), 'linked_account_notes'=>array('branch'), 'on_hold'=>'1', 'on_hold_until'=>'1671222870')));

                        print_r($response1);exit;*/
                        
						if($response){
						    
						    
						    
							$id     = Auth::user()->id;
							$user   = Auth::user();
							
							$resdata = array("order_id"=>$id ,'user_id' => $id,"response"=>json_encode($response->toArray()));
							   
							DB::table('razorpay_response')->where("id",$dt->id)->update($resdata);
							
							$currency_id                =   DB::table('students')->select('currency_id')->where('user_id',$id) ->get()->first();
							$registration_fee_type      =   DB::table('students')->select('registration_fee_type')->where('user_id',$id) ->get()->first();
							$currency_code              =   DB::table('currencies')->select('code')->where('id',$currency_id->currency_id) ->get()->first();
							$student_currency           =   $currency_code->code;
							
							$fee_pay = ($response->amount)/100;
							
							
							/*$data = array();
							$data['student_user_id'] = $id;
							$data['tutor_user_id'] = '0';
							$data['fee_type'] = 'class_fee';
							$data['payment_date'] = date('Y-m-d H:i:s');;
							$data['currency_id'] = $currency_id->currency_id;
							$data['amount'] = $fee_pay;
							$data['no_of_classes'] = '0';
							$data['payment_method_id'] = '1';
							$data['status'] = 'paid';
							$data['created_at'] = date('Y-m-d H:i:s');
							$data['updated_at'] = date('Y-m-d H:i:s');

							PaymentHistory::create($data);*/

							
								
								
								
							//$data                =  $this->getData($request, $id);
							$studentDetais       =  Student::where('user_id', $id)->first();
							$amountPay           =  $request->class_fee;
							$student['credits']  =  $studentDetais->credits + $amountPay;
							$studentDetais->update($student);
							$this->updatePaymentHistory($id,$studentDetais,$request);
							
							$paymentDetails   = User::Join('students', 'students.user_id', '=', 'users.id')
													->Join('classes', 'students.user_id', '=', 'classes.student_user_id')
													->select(['students.class_fee','classes.id as classIds'])
													->where('classes.is_paid','0')
													->where('users.id',$id)
													->orderBy('classes.id','asc')
													->get();
						   
						    if(count($paymentDetails) != 0){
							  foreach($paymentDetails as $payment){
									if($student['credits'] > 0)
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
      
 
							return redirect()->route('feepayment.fee.index')
								->with(['success_message' => trans('users.model_fee_updated'),'user_id' => $id]);	
								
						}else{
							//\Session::put('error_message',$e->getMessage());
							return redirect()->back()->with('error_message', "Something went wrong");;
						}
						
					//} catch (\Exception $e) {
						//return  $e->getMessage();
						//\Session::put('error_message',$e->getMessage());
						
					//	return redirect()->back()->with('error_message',$e->getMessage());
				//	}
				}else{
					//\Session::put('error_message',$e->getMessage());
					return redirect()->back()->with('error_message', "Something went wrong");;
				}
			}
			catch(SignatureVerificationError $e)
			{
				//$success = false;
				///$error = 'Razorpay Error : ' . $e->getMessage();
				return redirect()->back()->with('error_message',$e->getMessage());;
			}
		}
    }
}
