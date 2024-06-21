<?php

namespace App\Http\Controllers\Modules\Frontend\Project;

use Exception;
use App\Models\Roles;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Facades\LaravelTheme;
use App\Facades\EditorGrapesJs;
use App\Contracts\ModuleInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Repositories\PagesRepositori;
use App\Repositories\ProjectRepositori;

class ProjectController extends Controller implements ModuleInterface
{
    protected $path = 'modules.frontend.my-project';
    protected $role;
    protected $modules;
    protected $themes;
    protected $projectsRepositorie;
    protected $pageRepositori;

    public function __construct(
        LaravelTheme $theme, ProjectRepositori $projects, PagesRepositori $pagesRepositori
    ) {
        $this->role = Roles::where('name', 'user')->first();
        $this->modules = $this->role->modules;
        $this->themes = $theme;
        $this->projectsRepositorie = $projects;
        $this->pageRepositori = $pagesRepositori;
    }

    public function index() : View {
        $projects = $this->projectsRepositorie->all();
        return view($this->path.'.index', compact('projects'));
    }

    public function create(Request $request) : View {
        try {

            $theme = LaravelTheme::findTheme($request->theme);
            
            if(empty($theme)) throw new Exception('Tema tidak ditemukan...');

            return view($this->path.'.create', compact('theme'));

        }catch(\Exception $err) {
            abort(404, $err->getMessage());
        }
    }

    public function store(ProjectRequest $request) {
        DB::beginTransaction();
        try {

            // create project
            $project = $this->projectsRepositorie->create($request->all());

            $theme = $this->themes::findTheme($project->id_theme);
            $viewTheme = view('themes/'.$theme['name'].'/'.'index', compact('theme'))->render();
    
            // Create initial page
            $page = $this->pageRepositori->create([
                'title' => 'Home',
                'style' => '',
                'content' => $viewTheme,
                'uuid_project' => $project->uuid
            ]);
            
            // commit transaction
            DB::commit();
            return redirect()->route('user.my-project.workspace', ['uuid' => $project->uuid->toString()]);

        }catch(\Exception $err) {
            DB::rollback();
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    public function workspace($uuid) {

        $project = $this->projectsRepositorie->find($uuid);
        $theme = $this->themes::findTheme($project->id_theme);

        return view($this->path.'.workspace', compact('project', 'theme'));
    }

    public function getContentTheme() {
        return LaravelTheme::renderContent();
    }
}
