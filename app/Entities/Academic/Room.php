<?php

namespace App\Entities\Academic;

use App\User;
use App\Entities\Academic\Grade;
use App\Entities\Academic\Parallel;
use App\Entities\Academic\Designation;
use App\Entities\Academic\Suscription;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'year', 'is_enabled', 'grade_id', 'parallel_id', 'adviser_id', 'user_id'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function adviser () {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    public function parallel () {
        return $this->belongsTo(Parallel::class);
    }

    public function grade () {
        return $this->belongsTo(Grade::class);
    }

    public function designations () {
        return $this->hasMany(Designation::class);
    }

    public function suscriptions () {
        return $this->hasMany(Suscription::class);
    }
}
