<?php
namespace App\Controllers\Builder;
use App\Controllers\Core\CoreController;
use App\Libraries\Datatable;

class Documentation extends CoreController
{
    public function index()
    {
        return $this->get_theme('builder/documentation/formbasic',null,get_class($this));
    }

    public function form_advance()
    {
        return $this->get_theme('builder/documentation/formadvance',null,get_class($this));
    }

    public function datatable_helper()
    {
        return $this->get_theme('builder/documentation/datatable_helper',null,get_class($this));
    }

    public function html_helper()
    {
        return $this->get_theme('builder/documentation/html_helper',null,get_class($this));
    }

    public function data_row()
    {
        $datatable = new Datatable();
        $attr 	= $this->request->getPost();
        $config = $datatable->init(
            [
                "attr"              => $attr,
                "filter"            => [],
                "model"             => [
                    "name"          => "builder\DocumentationModel",
                    "resource"      => "get_dataTable"
                ],
                "rightTool"         => function($param){
                    $resp = "";
                    if ($param["menu_status"] == "t") {
                        $resp = create_btnAction([
                            "update"=>[
                                "id_key"        => $param["id_key"],
                                "url"           => "builder/documentation/find_one",
                                "loadForm"      => "builder/documentation/show_form"
                            ],
                            "delete"=>[
                                "id_key"  => $param["id_key"],
                                "url"     => "builder/documentation/delete_row"
                            ]
                        ]);
                    }else{
                        $resp = null;
                    }
                    return $resp;
                }
            ]
        );
        echo json_encode($config);
    }
}
