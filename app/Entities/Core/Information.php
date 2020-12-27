<?php

namespace App\Entities\Core;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';

    protected $fillable = [
        'ci', 'rude', 'father_name', 'mother_name', 'phone', 'adress', 'birthday',
        'work_from', 'site', 'gender', 'procedent', 'father_occupation', 'mother_occupation', 
        'father_email', 'mother_email', 'father_phone', 'mother_phone', 'tutor_phone', 
        'tutor_email', 'size', 'medic', 'blood_type', 'user_id'
    ];

    protected $casts = [
        'birthday'  =>  'date',
        'work_from' =>  'date'
    ];

    protected $appends = [
        'birthday_date', 'work_from_date'
    ];

    public function getBirthdayDateAttribute () {
        return $this->birthday->toDateString();
    }

    public function getWorkFromDateAttribute () {
        return $this->work_from ? $this->work_from->toDateString() : '';
    }

    public function user () {
        return $this->belongsTo(User::class);
    }
}
