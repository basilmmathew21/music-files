<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TutorEnquiry extends Model
{
    use HasFactory;
    protected $fillable = ['name','dob','email','phone','gender','country_id','state','address','profile_image','status','teaching_stream','educational_qualification','teaching_experience','performance_experience','other_details','date_of_enquiry'];

    public function accept_register($id){
     
        //Update Tutor Enquiry Table

        $accept= TutorEnquiry::where('id', $id)->update(['status' => 'accepted']);
            
       //User table insertion
        $password =  Hash::make(Str::random(8));
        $user_type_id = 3;

        $user_enquiry=DB::table('tutor_enquiries')->where('id',$id)->get()->first(); //fetch from enquiry table

        //User Table

        $user = DB::table('users')->insert([
            'name'  		 =>   $user_enquiry->name,
            'email'	 		 =>  $user_enquiry->email,
            'phone'			 =>	  $user_enquiry->phone,
            'user_type_id'	 		 =>    $user_type_id,
            'gender'	 			 =>   $user_enquiry->gender,
            'dob'	 		 =>  Carbon::parse($user_enquiry->dob)->format('Y-m-d'),
            'country_id'  		 =>  $user_enquiry->country_id,
            'state'	 		 =>   $user_enquiry->state,
            'address'			 =>	  $user_enquiry->address,
            'profile_image'	 		 =>    $user_enquiry->profile_image,
            'password'	 			 =>   $password,
            'is_active'	 			 =>   0,
            'created_at'            =>date('Y-m-d H:i:s')
        ]);

       $id_for_tutor = User::where('email', '=', $user_enquiry->email)->first()->toArray();
          //Tutor Table
          $tutor = DB::table('tutors')->insert([
            'user_id'  		 =>   $id_for_tutor['id'],
            'teaching_stream'	 		 =>   $user_enquiry->teaching_stream,
            'educational_qualification'			 =>	  $user_enquiry->educational_qualification,
            'teaching_experience'	 		 =>    $user_enquiry->teaching_experience,
            'performance_experience'	 			 =>   $user_enquiry->performance_experience,
            'other_details'	 		 =>   $user_enquiry->other_details,
            'created_at'  		 =>  date('Y-m-d H:i:s')
            
        ]);

       
        


 return true;
    }

    public function reject_enquiry($id)
    {
        $reject= TutorEnquiry::where('id', $id)->update(['status' => 'rejected']);
        return true;
    }
    
}
