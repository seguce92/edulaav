<?php

namespace App\Entities\Academic;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    protected $table = 'suscriptions';

    protected $fillable = [
        'year', 'is_enabled', 'room_id', 'student_id', 'user_id'
    ];

    public static function searchable () {
        return [
            'student.name', 'student.lastname', 'student.information.ci', 'student.information.rude'
        ];
    }

    protected $appends = [
        'created_at_human'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function student () {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function room () {
        return $this->belongsTo(Room::class);
    }
}
