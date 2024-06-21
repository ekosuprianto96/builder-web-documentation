<?php

namespace App\Services;

use App\Facades\LaravelTheme;
use App\Repositories\ProjectRepositori;
use App\Repositories\PagesRepositori;

class EditorGrapesJs {

    protected $laraveTheme;
    protected $theme;
    protected $blocks;
    protected $pages;
    protected $pagesRepositori;
    protected $projectRepositori;

    public function __construct(
        LaravelTheme $theme, PagesRepositori $pagesRepositori, ProjectRepositori $projectRepositori
    ) {
        $this->laraveTheme = $theme;
        $this->pagesRepositori = $pagesRepositori;
        $this->projectRepositori = $projectRepositori;
    }

    public function select(string $id_theme) {
        $theme = $this->laraveTheme::findTheme($id_theme);
        $this->theme = $theme;
        return $this;
    }

    public function configEditor() {
        $theme = $this->theme;
        $config = file_get_contents(base_path().'/resources'.'/views/themes/'.$this->theme['name'].'/'.'editor.json');
        return json_decode($config, true);
    }

    public function getBlocks() {
        $config = $this->configEditor();
        foreach($config['blocks'] as $key => $conf) {
            $config['blocks'][$key]['content'] = view('themes.'.$conf['content'])->render();
        }
        $this->blocks = $config;
        return $this->blocks['blocks'];
    }

    public function getPages(string $id_project) {
        $project = $this->projectRepositori->find($id_project);
        $pages = $project->pages;
        return $pages;
    } 
}