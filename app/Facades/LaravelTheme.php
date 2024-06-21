<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTheme extends Facade {
    protected static function getFacadeAccessor() {
        return 'laravelTheme';
    }
}