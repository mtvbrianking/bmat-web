<?php

namespace App\Traits;

/**
 * Trait Uuids
 * @link https://medium.com/@steveazz/setting-up-uuids-in-laravel-5-552412db2088
 */
trait Uuids
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if(is_null($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = \Ramsey\Uuid\Uuid::uuid4()->toString();
            }
        });
    }
}
