<?php

namespace App\Contracts;

interface ProjectRepositoriesInterface
{
    public function all();
    public function find($uuid);
    public function create(array $data);
    public function update();
    public function delete();
}
