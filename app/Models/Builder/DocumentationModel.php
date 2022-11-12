<?php

namespace App\Models;

use CodeIgniter\Model;

class CobaModel extends Model
{
    protected $table      		= 'ms_menu';
    protected $primaryKey 		= 'menu_id';
	protected $returnType     	= 'object';

	protected $column = [
		"menu_code",
		"menu_name",
		"menu_url",
		"menu_parent_id",
		"menu_status",
		"menu_icon",
		"menu_id"
	];

	public function get_dataTable($sLimit, $sWhere, $sOrder,$aColumns)
	{
		$query = "SELECT " . implode(',', $aColumns) . ",$this->primaryKey as id_key 
		from ms_menu
		where 0=0 $sWhere";
		$db = \Config\Database::connect();
		$data['countRow'] = $db->query($query)->getNumRows();
		$query .= $sOrder." ".$sLimit;
		$data['row'] = $db->query($query)->getResultArray();
		return $data;
	}
}