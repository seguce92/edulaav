<?php

namespace App\Entities\Academic;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'title', 'file_name', 'content', 'year', 'grade_id', 'user_id'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
