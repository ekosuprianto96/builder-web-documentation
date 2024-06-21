<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Frontend\Module\Modules;
use App\Models\Roles;
use Symfony\Component\HttpFoundation\Response;

class LoadModules
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) :Response
    {
        // Mengambil data dari model Modules
        $role = Roles::first();

        // Membagikan data ke view
        view()->share('modules', $role->modules);
        view()->share('role', $role->name);

        return $next($request);
    }
}
