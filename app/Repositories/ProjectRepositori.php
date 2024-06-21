<?php

namespace App\Repositories;

use App\Models\Projects;
use Illuminate\Support\Str;
use App\Contracts\ProjectRepositoriesInterface;

class ProjectRepositori implements ProjectRepositoriesInterface {

    public function all() {
        return Projects::all();
    }

    public function find($uuid) {
        return Projects::findOrFail($uuid);
    }

    public function create(array $data)
    {
        $project = new Projects();
        $project->name = $data['name'];
        $project->descriptions = $data['descriptions'];
        $project->id_theme = $data['id_theme'];
        $project->uuid_user = '35794a60-24a7-43fe-8675-461c709d2aea';
        $project->save();

        return $project;
    }


    public function update()
    {
        return   ;
    }

    public function delete()
    {
        
    }
}