<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectTemp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Project::class, 'uuid_project', 'uuid');
    }
}
