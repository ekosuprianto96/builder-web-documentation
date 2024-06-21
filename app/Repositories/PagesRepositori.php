<?php

namespace App\Repositories;

use App\Contracts\PagesRepositoriInterface;
use App\Models\Pages;
use Exception;

class PagesRepositori implements PagesRepositoriInterface {

    public function all() {
        return Pages::all();
    }

    public function find(string $id_page) {
        return Pages::findOrFail($id_page);
    }

    public function create(array $param) {
        $page = new Pages();
        $page->title = $param['title'];
        $page->style = $param['style'];
        $page->content = $param['content'];
        $page->uuid_project = $param['uuid_project'];
        $page->save();
        return $page;
    }

    public function delete(string $id_page) {
        try {

            $page = Pages::findOrFail($id_page);

            if(empty($page)) throw new \Exception('Page tidak ditemukan.');

            $page->delete();

            return true;
        }catch(\Exception $err) {
            throw new \Exception($err->getMessage());
            return false;
        }
    }

    public function update($id_page, $param) {
        try {

            $page = $this->find($id_page);
        
            if(empty($page)) {
                throw new \Exception('Page tidak ditemukan.');
            }

            $page->update($param);

            return true;

        }catch(\Exception $err) {
            throw new \Exception($err->getMessage());
            return false;
        }
    }

}