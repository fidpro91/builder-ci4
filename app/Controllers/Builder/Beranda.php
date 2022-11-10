<?php

namespace App\Controllers\Builder;
use App\Controllers\BaseController;

class Beranda extends BaseController
{
    public function index()
    {
        return view('builder/home');
    }

    public function generate_db()
    {
        $dbname = $this->request->getPost('db_name');

        // $this->db
        return redirect()->to("builder/builderform");
    }
}
