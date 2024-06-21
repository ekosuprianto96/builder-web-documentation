<?php

namespace App\Models;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pages extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Projects::class, 'uuid_project', 'uuid');
    }
}
