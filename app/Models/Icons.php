<?php

namespace App\Models;

use App\Models\Frontend\Module\Menu;
use App\Models\Frontend\Module\Modules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icons extends Model
{
    use HasFactory;

    public function modules() {
        return $this->hasMany(Modules::class, 'icon', 'id');
    }
}
