<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorClass extends Model
{
    use HasFactory;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classes';
    
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_user_id','tutor_user_id','currency_id','class_fee','date','summary','is_paid'
    ];

    

}
