<?php

namespace App\Models\Frontend\Module;

use App\Models\Icons;
use App\Models\Roles;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modules extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'primary_modules'];
    protected $primaryKey = 'primary_modules';
    public $keyType = 'string';
    public $incrementing = false;

    protected static function boot() {
        parent::boot();

        parent::creating(function($modules) {
            $modules->primary_modules = Str::uuid();
        });
    }

    public function menus() {
        return $this->hasMany(Menu::class, 'primary_modules', 'primary_modules');
    }

    public function roles() {
        return $this->belongsToMany(Roles::class, 
        'module_roles', 
        'primary_modules', 
        'uuid_role', 
        'primary_modules', 
        'uuid', 
        'module_roles');
    }

    public function iconMenu() {
        return $this->belongsTo(Icons::class, 'icon', 'id');
    }
}
