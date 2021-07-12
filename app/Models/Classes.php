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

}
