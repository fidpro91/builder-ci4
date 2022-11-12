<?php

namespace App\Models\Builder;

use CodeIgniter\Model;

class Table_buildedModel extends Model
{
    protected $table      		= 'table_builded';
    protected $primaryKey 		= 'id_task';
	protected $returnType     	= 'object';
    protected $allowedFields    = [
		"id_task",
		"table_name",
		"controller",
		"model",
		"views",
		"user_created",
		"created_at",
];

    protected $validationRules    = [
        		"table_name" => "trim|required",
		"controller" => "trim|integer",
		"model" => "trim|integer",
		"views" => "trim|integer",
		"user_created" => "trim|integer",
		"created_at" => "trim"
    ];
    
    protected $useAutoIncrement = true;
    protected $skipValidation  = false;

	protected $column = [];

    public function __construct()
    {
        parent::__construct();
        $this->column = [
            
		"id_task",
		"table_name",
		"controller" => [
			"custom" => function($a){
				if ($a['controller'] == 1) {
					$label = "<span class='badge badge-success'><i class='fa fas fa-check-circle'></i</span>";
				}else{
					$label = "<span class='badge badge-danger'><i class='fa fas fa-minus-circle'></i</span>";
				}
				return $label;
			}
		],
		"model" => [
			"custom" => function($a){
				if ($a['model'] == 1) {
					$label = "<span class='badge badge-success'><i class='fa fas fa-check-circle'></i</span>";
				}else{
					$label = "<span class='badge badge-danger'><i class='fa fas fa-minus-circle'></i</span>";
				}
				return $label;
			}
		],
		"views" => [
			"custom" => function($a){
				if ($a['views'] == 1) {
					$label = "<span class='badge badge-success'><i class='fa fas fa-check-circle'></i</span>";
				}else{
					$label = "<span class='badge badge-danger'><i class='fa fas fa-minus-circle'></i</span>";
				}
				return $label;
			}
		],
		"user_created",
		"created_at",
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