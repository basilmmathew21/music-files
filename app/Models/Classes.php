<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
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
        'student_user_id','tutor_user_id','date','summary','is_paid'
    ];

    /**
     * Get the Student record associated with the user.
     */
    public function student_user()
    {
        return $this->hasOne(User::class,'student_user_id');
    }

     /**
     * Get the Tutor record associated with the user.
     */
    public function tutor_user()
    {
        return $this->hasOne(Tutor::class,'tutor_user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class,'id','name');
    }

}
