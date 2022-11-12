<?php

namespace App\Models\Builder;

use CodeIgniter\Model;

class User_developerModel extends Model
{
    protected $table      		= 'user_developer';
    protected $primaryKey 		= 'user_id';
	protected $returnType     	= 'object';
    protected $allowedFields    = [
		"user_id",
		"username_developer",
		"password_developer",
		"password_encrypted",
];

    protected $validationRules    = [
        "username_developer" => "trim|required",
		"password_developer" => "trim|required",
		"password_encrypted" => "trim|required"
    ];
    
    protected $useAutoIncrement = true;
    protected $skipValidation  = false;

	protected $column = [];

    public function __construct()
    {
        parent::__construct();
        $this->column = [
            
		"user_id",
		"username_developer",
		"password_developer",
		"password_encrypted",

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