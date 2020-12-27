<?php

namespace App\Entities\Lms;

use App\User;
use App\Entities\Lms\Task;
use App\Entities\Academic\Designation;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    
    protected $fillable = [
        'title', 'designation_id', 'teacher_id'
    ];

    protected $appends = [
        'created_at_human', 'updated_at_human'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function getUpdatedAtHumanAttribute () {
        return $this->updated_at->format('d/m/Y H:m:s');
    }

    public function teacher () {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function designation () {
        return $this->belongsTo(Designation::class);
    }

    public function tasks () {
        return $this->hasMany(Task::class);
    }
}
