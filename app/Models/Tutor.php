<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class Tutor extends Model
{
    use HasFactory;
    
    public function addtutor($request, $fileNameToStore){
     
        
        $password = Hash::make($request->password); //Encrypting password
        $country_id    = $request->country; //country
        $user_type_id = 3;

        //User Table

        $user = DB::table('users')->insert([
            'name'  		 =>   $request->name,
            'email'	 		 =>  $request->email,
            'phone'			 =>	  $request->phone,
            'user_type_id'	 		 =>    $user_type_id,
            'gender'	 			 =>   $request->gender,
            'dob'	 		 =>  Carbon::createFromFormat('d-m-y',$request->dob)->format('Y-m-d'),
            'country_id'  		 =>  $country_id,
            'state'	 		 =>   $request->state,
            'address'			 =>	  $request->address,
            'profile_image'	 		 =>    $fileNameToStore,
            'password'	 			 =>   $password,
            'is_active'	 			 =>   $request->status,
            'created_at'            =>date('Y-m-d H:i:s')
        ]);

       $id_for_tutor = User::where('email', '=', $request->email)->first()->toArray();
          //Tutor Table
          $tutor = DB::table('tutors')->insert([
            'user_id'  		 =>   $id_for_tutor['id'],
            'teaching_stream'	 		 =>   $request->teaching_stream,
            'educational_qualification'			 =>	  $request->educational_qualification,
            'teaching_experience'	 		 =>    $request->teaching_experience,
            'performance_experience'	 			 =>   $request->performance_experience,
            'other_details'	 		 =>   $request->other_details,
            'created_at'  		 =>  date('Y-m-d H:i:s')
            
        ]);

        //Tutor Student Table
      $students=$request->students;
      if($students)
      {
        foreach($students as $stud)
        {
            $tutor_student = DB::table('tutor_students')->insert([
                'user_id'  		 =>$stud ,
                'tutor_id'	 		 =>   $id_for_tutor['id'],
                'created_at'  		 =>  date('Y-m-d H:i:s')
                
            ]);
        }

      }
       
        


 return true;
    }
    public function updatetutor($request, $fileNameToStore,$id){
        $user   =  DB::table('users')->where('id', $id)->first();

        if($request->password)
            $password = Hash::make($request->password); //Encrypting password
        else
            $password =$user->password;
        if($fileNameToStore=="")
            $fileNameToStore=$user->profile_image;
        
        $country_id    = $request->country; //country
        $user_type_id = 3;

        //User Table

        $user = DB::table('users')->where('id', $id)->update([
            'name'  		 =>   $request->name,
            'email'	 		 =>  $request->email,
            'phone'			 =>	  $request->phone,
            'user_type_id'	 		 =>    $user_type_id,
            'gender'	 			 =>   $request->gender,
            'dob'	 		 =>  Carbon::createFromFormat('d-m-y',$request->dob)->format('Y-m-d'),
            'country_id'  		 =>  $country_id,
            'state'	 		 =>   $request->state,
            'address'			 =>	  $request->address,
            'profile_image'	 		 =>    $fileNameToStore,
            'password'	 			 =>   $password,
            'is_active'	 			 =>   $request->status,
            'updated_at'            =>date('Y-m-d H:i:s')
        ]);

       
          //Tutor Table
          $tutor = DB::table('tutors')->where('user_id', $id)->update([
           
            'teaching_stream'	 		 =>   $request->teaching_stream,
            'educational_qualification'			 =>	  $request->educational_qualification,
            'teaching_experience'	 		 =>    $request->teaching_experience,
            'performance_experience'	 			 =>   $request->performance_experience,
            'other_details'	 		 =>   $request->other_details,
            'updated_at'  		 =>  date('Y-m-d H:i:s')
            
        ]);

        //Tutor Student Table
        $Selectedstudents= DB::table('tutor_students')
        ->select('id') ->where('tutor_id', $id)->get();
          
        if(count($Selectedstudents)>0)
        {
            
            foreach($Selectedstudents as $key=>$value)
            {
                DB::table('tutor_students')->where('id', $value->id)->delete();
            
            }
        }
      
        
      $students=$request->students;
      if($students)
      {
        foreach($students as $stud)
        {
           
                $tutor_student = DB::table('tutor_students')->insert([
                    'user_id'  		 =>$stud ,
                    'tutor_id'	 		 =>   $id,
                    'updated_at'  		 =>  date('Y-m-d H:i:s')
                    
                ]);

           
        }
     
      }


     return true;
    }
    public function deletetutors($request){
       // $sliders =  DB::table('home_sliders')->where('id', $request->slider_id)->delete();
        return true;
      }
}
