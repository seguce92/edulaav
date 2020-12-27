<?php

namespace App\Entities\Academic;

use App\User;
use App\Entities\Academic\Grade;
use Illuminate\Database\Eloquent\Model;

class Parallel extends Model
{
    protected $table = 'parallels';

    protected $fillable = [
        'code', 'title', 'is_enabled', 'grade_id', 'user_id'
    ];

    public static function searchable () {
        return [
            'code', 'title'
        ];
    }

    protected $casts = [
        'is_enabled'    =>  'Boolean'
    ];

    protected $appends = [
        'created_at_human', 'status'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function getStatusAttribute () {
        return $this->is_enabled ? 'Activo' : 'Inactivo';
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function grade () {
        return $this->belongsTo(Grade::class);
    }
}
