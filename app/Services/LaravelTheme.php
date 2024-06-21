<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LaravelTheme {

    protected $path;
    protected $config;
    protected $themes;
    protected $currentTheme;

    public function __construct($theme = '')
    {
        $this->path = resource_path('views/themes');
        $this->themes = $this->getThemes()->get();
    }



    public function getThemes() {
        $directories = File::directories($this->path);
        $array = array_map(function($directorie) {
            return basename($directorie);
        }, $directories);

        $this->themes = $array;
        return $this;
    }

    public function getTheme($name) {
        $theme = $this->getConfigTheme($name);
        return (object) $theme;
    }

    public function getConfigTheme($name) {
        
        $config = file_get_contents(base_path().'/resources'.'/views/themes/'.$name.'/'.'config.json');
        return json_decode($config, true);
    }

    public function setCurrentTheme() {

    }

    public function findTheme($id) {
        $result = null;
        foreach($this->themes as $key => $theme) {
            $config = $this->getConfigTheme($key);
            if($config['id'] === $id) {
                $result = $config;
            }else {
                continue;
            }
        }

        return $result;
    }

    public function get() {
        $array = [];

        foreach($this->themes as $theme) {
            $config = (object) $this->getConfigTheme($theme);
            $array[$theme]['config'] = $config;
        }

        return $array;
    }

    public function renderContent() {
        $themes = $this->getThemes()->get();
        return view('modules.frontend.components.content-themes', compact('themes'));
    }
}