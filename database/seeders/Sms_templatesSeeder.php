<?php

namespace Database\Seeders;

use App\Models\SmsTemplates;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Sms_templatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sms_templates')->truncate();

        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Hello (Student)! Very nice to meet you !! I'm (Tutor), your (stream) teacher."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), My available time slots in IST are (Day, Time AM/PM), --,--,--,--,--,--"]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), Please choose your convenient slot or suggest your convenient timings."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student),I will be available at __AM/PM(IST) on (Day)"]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Ok. Thank you.Shall meet in the class."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "__is the link (Skype/zoom/google meet) for attending the class."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), This week's class reminder,IST (Day, Time AM/PM)."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), The scheduled class of (Date,time) stands cancelled due to unforesseen reasons.We shall inform you of the rescheduled time and date."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), Shall we reschedule our missed class to (Date,TIme). Confirm your availability,or suggest your convenient date and time."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), Sorry, getting delayed due to some reason. Shall I connect you in (_) minutes?"]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), internet connection is lost. Trying to fix it."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student), I'm online."]);
        SmsTemplates::create(['to_user_type_id' => '4','from_user_type_id' => '3','message' => "Dear (Student). No problem.)"]);

        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), Nice to meet you."]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), I will be available at __AM/PM(IST) on (Day)."]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), My convenient timings are IST (Day, Time AM/PM)"]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), Thanks you."]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), Soory, Shall we cancel our class scheduled on IST (Day,Time)?"]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), Shall we reschedule our missed class on IST (Day,Time)?"]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), internet connection is lost.Trying to fix it."]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), I'm online."]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Dear (Ma'am/Sir), Sorry,getting delayed due to some reason. Shall I connect you in (_) minutes?"]);
        SmsTemplates::create(['to_user_type_id' => '3','from_user_type_id' => '4','message' => "Ok (Ma'am/Sir), No problem."]);
    }
}
