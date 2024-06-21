<?php

namespace App\Http\Controllers\Modules\Admin\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModuleRequest;
use App\Models\Frontend\Module\Modules;
use App\Models\Roles;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $path = 'modules.admin.module';
    protected $role;
    protected $modules;

    public function __construct()
    {
        $this->role = Roles::first();
        $this->modules = $this->role->modules;
    }

    public function index() {

        $modules_data = Modules::get();
        return view($this->path.'.index', compact('modules_data'));
    }

    public function store(ModuleRequest $request) {
        dd($request);
        // return 'Hello Coba';
    }
}
