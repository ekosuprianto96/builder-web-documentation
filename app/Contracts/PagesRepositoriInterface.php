<?php

namespace App\Contracts;

interface PagesRepositoriInterface
{
    public function all();
    public function find(string $id_page);
    public function create(array $param);
    public function delete(string $id_page);
}
