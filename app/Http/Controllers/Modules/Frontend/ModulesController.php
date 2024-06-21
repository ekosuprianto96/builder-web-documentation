<?php

namespace App\Http\Controllers\Modules\Frontend;

use App\Traits\Module;
use Illuminate\Http\Request;
use App\Services\LaravelTheme;
use App\Http\Controllers\Controller;

class ModulesController extends Controller
{

    private $theme;

    use Module;

    public function __construct(
        LaravelTheme $theme, 
    ) {
        $this->theme = $theme;
    }
    
    public function show($module, $menu)
    {
        // Validasi dan cek apakah modul dan menu ada
        $module = self::findModule($module);

        $themes = $this->theme;

        session()->put('module', $module->primary_modules);

        return $this->view(compact('module', 'themes'));
    }
}
