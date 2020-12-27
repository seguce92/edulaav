<?php

namespace App\Entities\Lms;

use App\Entities\Lms\Topic;
use App\Entities\Academic\Designation;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title', 'content', 'points', 'date', 'time', 'type', 'designation_id', 'topic_id', 'array_files'
    ];

    protected $casts = [
        'array_files' => 'array',
    ];

    public function designation () {
        return $this->belongsTo(Designation::class);
    }

    public function topic () {
        return $this->belongsTo(Topic::class);
    }
}
