<?php

if(!function_exists('isActive')) {
    function isActive($name) {
        $currentName = request()->route()->getName();
        
        if($currentName === $name) return 'bg-slate-200';

        return '';
    }
}
if(!function_exists('icon')) {
    function icon($menu) {
        return $menu->icon->value ?? '';
    }
}