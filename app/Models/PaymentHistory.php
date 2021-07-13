<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_histories';

    protected $fillable = ['student_user_id','tutor_user_id','fee_type','payment_date','currency_id','amount','no_of_classes','payment_method_id','status','created_at','updated_at'];
}
