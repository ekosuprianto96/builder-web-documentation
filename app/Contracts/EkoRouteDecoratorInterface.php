<?php

namespace App\Contracts;

use Illuminate\Routing\RouteRegistrar;

interface EkoRouteDecoratorInterface {

    public function admin() : RouteRegistrar;

    public function user() : RouteRegistrar;

}