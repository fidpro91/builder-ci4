<?php

namespace App\Models;

use CodeIgniter\Model;

class BuilderModel extends Model
{
	protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function get_all_table()
    {
        return $this->db->listTables();
    }
}