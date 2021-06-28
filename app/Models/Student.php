<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';
    
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','country_id','course_id'
    ];

    /**
     * Get the user that student belongs.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
