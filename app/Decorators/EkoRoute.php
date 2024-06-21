<?php

namespace App\Decorators;

use App\Contracts\EkoRouteDecoratorInterface;
use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;

class EkoRoute implements EkoRouteDecoratorInterface {

    protected $router;

    public function __construct(Router $router) 
    {
        $this->router = $router;
    }

    public function admin(string $group = null) : RouteRegistrar {
        
        if(isset($group)) return $this->router->prefix('admin'.'/'.$group)->name('admin.'.$group)->middleware(['admin', 'modules-admin']);
    
        return $this->router->prefix('admin')->name('admin')->middleware(['admin', 'modules-admin']);
    }

    public function user(string $group = null) : RouteRegistrar {

        if(isset($group)) return $this->router->prefix('user/'.$group)->name('user.'.$group)->middleware(['modules-user']);

        return $this->router->prefix('user')->name('user')->middleware(['modules-user']);
    }

    public function base() :object {
        return $this->router;
    }

    // Passthrough to Router for other route definitions
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->router, $method], $parameters);
    }
}