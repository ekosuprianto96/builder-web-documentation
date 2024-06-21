<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Facades\LaravelTheme;
use App\Facades\EkoMarkDownParse;
use League\CommonMark\CommonMarkConverter;

class ThemeController extends Controller
{
    public function preview($theme) {
        $theme = LaravelTheme::findTheme($theme);
        $content = Str::markdown(file_get_contents(base_path('README.md')));
        $content = '<div class="markdown-content">' . $content . '</div>';
        // dd($content);
        return view(config('theme.view_path').'.'.$theme['name'].'.index', compact('theme', 'content'))->render();
    }
} 
