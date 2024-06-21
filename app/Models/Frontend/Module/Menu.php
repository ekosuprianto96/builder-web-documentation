<?php

namespace App\Models\Frontend\Module;

use App\Models\Icons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory; 

    public function module() {
        return $this->belongsTo(Modules::class, 'primary_modules', 'primary_modules');
    }

    public function iconMenu() {
        return $this->belongsTo(Icons::class, 'icon', 'id');
    }
}
