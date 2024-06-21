<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EkoRoute extends Facade {
    protected static function getFacadeAccessor() {
        return 'ekoRoute';
    }
}