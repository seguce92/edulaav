<?php

namespace App\Entities\Academic;

use App\User;
use App\Entities\Academic\Room;
use App\Entities\Academic\Subject;
use App\Entities\Academic\Document;
use App\Entities\Academic\Parallel;
use App\Entities\Academic\Designation;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';

    protected $fillable = [
        'code', 'title', 'user_id', 'is_enabled'
    ];

    protected $casts = [
        'is_enabled'    =>  'Boolean'
    ];

    protected $appends = [
        'created_at_human', 'count_parallel', 'count_subject'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function getCountParallelAttribute () {
        return $this->parallels->count();
    }

    public function getCountSubjectAttribute () {
        return $this->subjects->count();
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function parallels () {
        return $this->hasMany(Parallel::class);
    }

    public function subjects () {
        return $this->hasMany(Subject::class);
    } 

    public function designations () {
        return $this->hasMany(Designation::class);
    }

    public function rooms () {
        return $this->hasMany(Room::class);
    }

    public function documents () {
        return $this->hasMany(Document::class);
    }
}
