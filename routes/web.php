<?php

use App\Facades\EkoRoute;
use App\Http\Controllers\Modules\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Admin\Module\ModuleController;
use App\Http\Controllers\Modules\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Modules\Frontend\Editor\EditorController;
use App\Http\Controllers\Modules\Frontend\Project\ProjectController;
use App\Http\Controllers\ThemeController;

EkoRoute::base()->get('/', function() {
    return 'Hello Home';
})->name('home');

// -------------------- User Route -----------------
EkoRoute::user('')->get('', [FrontendDashboardController::class, 'index']);

// My Project
EkoRoute::user('my-project')->get('', [ProjectController::class, 'index']);
EkoRoute::user('my-project')->get('/create', [ProjectController::class, 'create'])->name('.create');
EkoRoute::user('my-project')->post('/store', [ProjectController::class, 'store'])->name('.store');
EkoRoute::user('my-project')->get('/workspace/{uuid}', [ProjectController::class, 'workspace'])->name('.workspace');
EkoRoute::user('my-project')->get('/content-theme', [ProjectController::class, 'getContentTheme'])->name('.content-theme');

// Route Editor
EkoRoute::user('web-base')->get('/editor/blocks/{id_theme}', [EditorController::class, 'getBlocks'])->name('.theme.blocks');
EkoRoute::user('web-base')->get('/editor/pages/{id_project}', [EditorController::class, 'getPages'])->name('.theme.pages');
EkoRoute::user('web-base')->post('/editor/pages/store/{id_project}', [EditorController::class, 'storePage'])->name('.theme.pages.store');
EkoRoute::user('web-base')->post('/editor/pages/destroy/{id_project}', [EditorController::class, 'destroyPage'])->name('.theme.pages.destroy');
EkoRoute::user('web-base')->post('/editor/pages/update-name/{id_project}', [EditorController::class, 'updateNamePage'])->name('.theme.pages.update-name');
EkoRoute::user('web-base')->post('/editor/pages/save-projects/{id_project}', [EditorController::class, 'saveProjects'])->name('.theme.pages.save-projects');

// -------------------- Admin Route -----------------
// route admin module
EkoRoute::admin()->get('', [DashboardController::class, 'index']);

// Route Module
EkoRoute::admin('module')->get('', [ModuleController::class, 'index']);
EkoRoute::admin('module')->post('/store', [ModuleController::class, 'store']);

// Route Theme
Route::get('/theme/preview/{id}', [ThemeController::class, 'preview'])->name('theme.preview');
Route::get('/themes/images/{theme}/{filename}', [DashboardController::class, 'getThumbnail'])->where('filename', '.*');