<?php
namespace App\Libraries;
class Datatable
{
    public function __construct()
    {
        //css
        $css = 
        link_tag('assets/themes/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')."\n";
        //plugins javascripts
        $this->scripts = 
        script_tag('assets/themes/libs/datatables/media/js/jquery.dataTables.min.js')."\n".
        script_tag('assets/dist/js/pages/datatable/custom-datatable.js');
        Config('App')->headerCss = $css.Config('App')->headerCss;
        Config('App')->footerJs = Config('App')->footerJs.$this->scripts;
    }

    public function init($config)
    {
        $attr       = $config['attr'];
        $model      = $config['model'];
        $search     = $attr['search']['value'];
        $sWhere     = "";
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'custom') {
                    $sWhere .= " AND $value";
                }else{
                    $sWhere .= " AND ".$key."='$value'";
                }
            }
        }
        $model = model("App\Models\\".$model['name']."");
        $dataResource   = $config['model']['resource'];

        $aColumns   = $aSearch   = [];
        foreach ($model->column as $key => $value) {
            if (!is_array($value)) {
                $aColumns[] = $aSearch[] = $value;
            }else{
                if (isset($value['field'])){
                    $key = $value['field']." AS ".$key;
                }
                if (isset($value['initial'])) {
                    $key = $value['initial'].'.'.$key;
                    $aSearch[] = (isset($value['field'])?$value['initial'].".".$value['field']:$key);
                }else{
                    $aSearch[] = (isset($value['field'])?$value['field']:$key);
                }
                $aColumns[] = $key;
            }
        }
        if ( isset($search) && $search != "" ) {
            $sWhere .= " AND (";
            for ( $i = 0 ; $i < count($aSearch) ; $i++ ) {
                    $sWhere .= " LOWER(".$aSearch[$i].") LIKE LOWER('%".pg_escape_string($search)."%') OR ";
            }
            $sWhere = substr_replace( $sWhere, "", - 3 );
            $sWhere .= ')';
        }

        /* $totalData = $this->db->query("								
				SELECT " . implode(',', $aColumns) . ",user_id as id_key where 0=0 $sWhere
			")->result();
         */
        // $iTotalRecords  = $totalData;
        $length = intval($attr['length']);
        // $length = $length < 0 ? $iTotalRecords : $length;
        $start  = intval($attr['start']);
        // $iSortCol_0 = $attr['order'][0]['column'];
        $sOrder = "";
        if ( isset($start) && $length != '-1' ) {
            $sLimit = " limit ".intval($length)." offset ".intval( $start );
        }

        if ( isset($attr['order'])) {
            $sOrder = "ORDER BY ";
            foreach ($attr['order'] as $key => $od) {
                $sOrder .= " ".$aColumns[$od['column']-2]." ".$od["dir"].",";
            }
            $sOrder = rtrim($sOrder,",");
        }
        
        $data = $model->{$dataResource}($sLimit,$sWhere,$sOrder,$aColumns);
        return $this->set_result($attr,$data,$model->column,$config["rightTool"]);
        
    }

    private function set_result($attr,$data,$fields,$tool)
	{
		$no   	= 1 + $attr['start'];
        $records        = [];
        $records["aaData"] = [];
        foreach ($data['row'] as $index=>$row) { 
			$obj = array($row['id_key'],$no);
			foreach ($fields as $key => $value) {
				if (is_array($value)) {
					if (isset($value['custom'])){
						$obj[] = call_user_func($value['custom'],$row);
					}else{
						$obj[] = $row[$key];
					}
				}else{
					$obj[] = $row[$value];
				}
			}
            if (is_callable($tool)) {
			    $obj[] = call_user_func($tool,$row);
            }
			$records["aaData"][] = $obj;
			$no++;
		}
        $records["draw"] = intval($attr['draw']);
        $records["iTotalRecords"] = $data['countRow'];
        $records["iTotalDisplayRecords"] = $data['countRow'];
        return ($records);
	}

    public function renderAjax($attr)
    {
        $defaultAttr = ["class"=>"table table-bordered" ,"style" => "width:100% !important;"];
        if (isset($attr['attribut'])) {
            $defaultAttr = array_replace_recursive($defaultAttr,$attr['attribut']);
        }
        $response = create_table($attr['id'],$attr['model'],$defaultAttr);
        $response .= 
        "   <script>
                var table_".$attr['id'].";
                $(document).ready(function() {
                    table_".$attr['id']." = $('#".$attr['id']."').DataTable(".$attr['dataTable'].");
                });
            </script>
        ";
        return $response;
    }

    public function render($attr)
    {
        $defaultAttr = ["class"=>"table table-bordered" ,"style" => "width:100% !important;"];
        if (isset($attr['attribut'])) {
            $defaultAttr = array_replace_recursive($defaultAttr,$attr['attribut']);
        }
        $response = create_table($attr['id'],$attr['model'],$defaultAttr);
        $js = "{ 
            'processing': true, 
            'scrollX': true, 
        }";

        $response .= 
        "   <script>
                var table;
                $(document).ready(function() {
                    table = $('#".$attr['id']."').DataTable($js);
                });
            </script>
        ";

        return $response;
    }
}
