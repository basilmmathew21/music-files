<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Lang;
use App\Models\User;
class Testimonial extends Model
{
    protected $table = 'testimonials';

    protected $fillable = ['user_id','title','description','status','is_active'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
        'updated_at' => 'datetime:d-M-Y'
    ];

    public function user()
    {       
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the User Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }
}
