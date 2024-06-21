<?php

namespace App\Models;

use App\Models\Frontend\Module\Modules;
use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory, GenerateUuid;

    protected $guarded = ['id', 'uuid'];
    protected $primaryKey = 'uuid';
    public $keyType = 'string';
    public $incrementing = false;

    public function modules() {
        return $this->belongsToMany(Modules::class, 
        'module_roles', 
        'uuid_role', 
        'primary_modules', 
        'uuid', 
        'primary_modules', 
        'module_roles');
    }
}
