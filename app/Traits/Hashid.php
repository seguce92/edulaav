<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait Hashid 
{

    protected static function bootHashid () {
        self::getHashAttribute();
    }

    public static function getHashAtributte () {
        return hashid_encode(static::getAttribute('id'));
    }

    /*public static function findByUuidOrFail($uuid)
    {
        return self::whereUuid($uuid)->firstOrFail();
    }*/
}