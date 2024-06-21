<?php

namespace App\Http\Controllers\Modules\Frontend;

use Illuminate\Http\Request;
use App\Services\LaravelTheme;
use App\Services\AsliNgodingModule;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $theme;
    private $module;
    protected $path = 'modules.frontend.dashboard';

    public function __construct(
        LaravelTheme $theme, 
    ) {
        $this->theme = $theme;
        $this->module = 'dashboard';
    }

    public function index() {

        $themes = $this->theme;
        return view($this->path.'.index', compact('themes'));
    }

    public function getThumbnail($theme, $filename) {
        $path = resource_path('views/themes/'.$theme.'/assets/images/'. $filename);
        // dd($path);
        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    }
}
