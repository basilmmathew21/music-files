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
        'user_id','display_name','country_id','course_id','online_class_link','mode_of_remittance','currency_id','class_fee','is_active','is_registered','credits'
    ];

    public function getIsActiveAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }

    /**
     * Get the user that student belongs.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    
}
