<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SmsTemplates extends Model
{
    use HasFactory;

    protected $table = 'sms_templates';

    protected $fillable = ['to_user_type_id','from_user_type_id','message'];
}
