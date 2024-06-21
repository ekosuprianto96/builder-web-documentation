<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EkoMarkDownParse extends Facade {
    protected static function getFacadeAccessor() {
        return 'ekoMarkDownParse';
    }
}