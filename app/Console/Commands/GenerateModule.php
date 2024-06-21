<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class GenerateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name} {--admin} {--admin-mm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller in folder Modules';

    /**
     * Execute the console command.
     */

    protected $controllers_path = 'App/Http/Controllers/Modules';

    public function handle()
    {
        $name = $this->argument('name');
        $isAdmin = $this->option('admin');
        $isAdminMM = $this->option('admin-mm');

        $modulePath = $isAdmin ? base_path($this->controllers_path."/Admin/$name") : base_path($this->controllers_path."/$name");

        if (!File::exists($modulePath)) {
            File::makeDirectory($modulePath, 0755, true);
        }

// Create the Controller
$controllerPath = $isAdmin ? $modulePath."/{$name}Controller.php" : $modulePath."/{$name}Controller.php";
$controllerNamespace = str_replace('/', '\\', $modulePath);

$controllerTemplate = "<?php
namespace $controllerNamespace;

use App\Http\Controllers\Controller;

class {$name}Controller extends Controller
{
    public function index()
    {
        //
    }
}
";
        File::put(base_path($controllerPath), $controllerTemplate);
        $this->info("Controller created successfully at $controllerPath");

        if ($isAdminMM) {
            // Create the Model
            Artisan::call('make:model', ['name' => "Modules/{$name}/{$name}"]);

            // Create the Migration
            Artisan::call('make:migration', ['name' => "create_{$name}_table"]);

            $this->info("Model and migration created successfully.");
        }

        return 0;
    }
}
