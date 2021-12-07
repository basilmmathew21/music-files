<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\Student;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\TutorClass;
use Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB as FacadesDB;

class RegfeeController extends Controller
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
     * Update the specified driver in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function paynow(Request $request)
    {
            $userid = FacadesAuth::user()->id;;
            $student = Student::where('user_id',$userid)->first();
            //Fetch Registration fee from database           
            $regfee_query              =   FacadesDB::table('settings')->select('value')->where('id',4) ->get()->first();
            $regfee                =   @$regfee_query->value;

            $student->regfee_date = date("Y-m-d H:i:s");
            $student->payment_method_id = '1';
            $student->is_registered = '1';
            $student->payment_status = 'paid';
            /*
                If student fee payment mode is Paid,the amount is substracted to credits
            */
           
            if($student->registration_fee_type == "Paid"){
            $student->credits  =   $student->credits - $regfee;
            }
            /*
                credit is substracted ends here
            */

            $student->save();

            
            //Assign Students Role on successful payment
            $user = User::find($userid);
            $user->assignRole('student');
            return redirect()->route('home')
                ->with('success_message', trans('students.regfee_success'));
       
    }    
}