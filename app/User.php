<?php

namespace App;

use App\Entities\Core\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'is_active', 'avatar', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function searchable () {
        return [
            'name', 'lastname', 'email'
        ];
    }

    protected $appends = [
        'created_at_human', 'updated_at_human', 'created_at_date', 'full_name'
    ];

    public function getCreatedAtHumanAttribute () {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedAtHumanAttribute () {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtDateAttribute () {
        return $this->created_at->format('d/m/Y H:m:s');
    }

    public function getFullNameAttribute () {
        return $this->name.' '.$this->lastname;
    }

    public function getAvatarAttribute ($value) {
        return $value ? asset('storage/profiles/' . $value) : asset('storage/profiles/default.png');
    }

    public function information () {
        return $this->hasOne(Information::class);
    } 
}
