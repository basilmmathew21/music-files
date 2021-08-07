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
            $student->regfee = $request['regfee'];
            $student->regfee_date = date("Y-m-d H:i:s");
            $student->payment_method_id = '1';
            $student->is_registered = '1';
            $student->payment_status = 'paid';
            $student->save();
            //Assign Students Role on successful payment
            $user = User::find($userid);
            $user->assignRole('student');
            return redirect()->route('home')
                ->with('success_message', trans('students.regfee_success'));
       
    }    
}