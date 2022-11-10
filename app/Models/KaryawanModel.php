<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table      		= 'karyawan';
    protected $primaryKey 		= 'id';
	protected $returnType     	= 'object';
    protected $allowedFields    = [
		"id",
		"nama",
		"tanggal",
		"jenis_kelamin",
		"alamat",
		"gaji",
];

    protected $validationRules    = [
        		"nama" => "trim|required",
		"tanggal" => "trim",
		"jenis_kelamin" => "trim",
		"alamat" => "trim",
		"gaji" => "trim|integer"
    ];
    
    protected $useAutoIncrement = true;
    protected $skipValidation  = false;

	protected $column = [];

    public function __construct()
    {
        parent::__construct();
        $this->column = [
            
		"id",
		"nama",
		"tanggal",
		"jenis_kelamin",
		"alamat",
		"gaji",

        ];
    }

	public function get_dataTable($sLimit, $sWhere, $sOrder,$aColumns)
	{
		$query = "SELECT " . implode(',', $aColumns) . ",$this->primaryKey as id_key 
		from $this->table
		where 0=0 $sWhere";
		$db = \Config\Database::connect();
		$data['countRow'] = $db->query($query)->getNumRows();
		$query .= $sOrder." ".$sLimit;
		$data['row'] = $db->query($query)->getResultArray();
		return $data;
	}
}