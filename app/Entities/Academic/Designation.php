<?php

namespace App\Entities\Academic;

use App\User;
use App\Entities\Lms\Task;
use App\Entities\Academic\Room;
use App\Entities\Academic\Grade;
use App\Entities\Academic\Subject;
use App\Entities\Academic\Parallel;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designations';

    protected $fillable = [
        'year', 'is_enabled', 'room_id', 'subject_id', 'teacher_id', 'user_id'
    ];

    public static function searchable () {
        return [
            'year', 
            'subject.title', 'subject.code', 'teacher.name', 'teacher.lastname', 'user.name',
            'teacher.email'
        ];
    }

    protected $casts = [
        'is_enabled'    =>  'Boolean'
    ];

    protected $appends = [
        'created_at_human'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room () {
        return $this->belongsTo(Room::class);
    }

    public function teacher () {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject () {
        return $this->belongsTo(Subject::class);
    }

    public function tasks () {
        return $this->hasMany(Task::class);
    }
}
