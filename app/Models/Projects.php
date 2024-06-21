<?php

namespace App\Models;

use App\Facades\LaravelTheme;
use App\Traits\GenerateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory, GenerateUuid;

    protected $guarded = ['id'];
    protected $primaryKey = 'uuid';
    public $keyType = 'string';
    public $incrementing = false;

    protected static function boot() {
        parent::boot();

        self::generate();
    }

    public function theme($name = 'name') {
        return LaravelTheme::findTheme($this->id_theme)[$name];
    }

    public function temp() {
        return $this->hasOne(ProjectTemp::class, 'uuid_project', 'uuid');
    }

    public function pages() {
        return $this->hasMany(Pages::class, 'uuid_project', 'uuid');
    }
}
