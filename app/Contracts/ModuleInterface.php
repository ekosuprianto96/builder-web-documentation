<?php

namespace App\Contracts;

use Illuminate\Contracts\View\View;

interface ModuleInterface
{    
    public function index() : View;
}
