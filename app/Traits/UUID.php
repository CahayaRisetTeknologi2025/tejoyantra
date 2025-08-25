<?php

namespace App\Traits;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

trait UUID
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Generator::uuid4()->tostring();
            }catch (UnsatisfiedDependencyException $e){
                abort(500, $e->getMessage());
            }
        });
    }
}
