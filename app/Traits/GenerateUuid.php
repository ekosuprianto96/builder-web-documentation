<?php 

namespace App\Traits;

use Exception;
use Illuminate\Support\Str;

trait GenerateUuid {

    public static function generate() {
        static::creating(function($model) {
            $model->uuid = Str::uuid();
        });
    }
}