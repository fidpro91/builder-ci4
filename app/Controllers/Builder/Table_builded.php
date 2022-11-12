<?php
namespace App\Controllers\Builder;
use App\Controllers\Core\CoreController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Builder\Table_buildedModel;
use App\Libraries\Datatable;
use App\Libraries\Formjos;
use App\Libraries\Formjos2;

class Table_builded extends CoreController
{
    use ResponseTrait;
    protected $model;
    public function __construct()
    {
        $this->model = new Table_buildedModel();
    }

    public function index()
    {
        $data['dataTable'] = new Datatable();
        return $this->get_theme('builder/table_builded/index',$data,get_class($this));
    }

    public function get_data()
    {
        $datatable = new Datatable();
        $attr 	= $this->request->getPost();
        $config = $datatable->init(
            [
                "attr"              => $attr,
                "filter"            => [],
                "model"             => [
                    "name"          => "Builder\Table_buildedModel",
                    "resource"      => "get_dataTable"
                ],
                "rightTool"         => function($param){
                    return create_btnAction([
                        "update"=>[
                            "id_key"        => $param["id_key"],
                            "url"           => "table_builded/find_one",
                            "loadForm"      => "table_builded/show_form"
                        ],
                        "delete"=>[
                            "id_key"  => $param["id_key"],
                            "url"     => "table_builded/delete_row"
                        ]
                    ]);
                }
            ]
        );
        return $this->respond($config,200);
    }

    public function save()
    {
        $input  = [];
        $post   = $this->request->getPost();
        foreach ($this->model->allowedFields as $key => $value) {
            $input[$value] = (!empty($post[$value])?$post[$value]:null);
        }

        if ($post["id_task"]) {
            $crud = $this->model->update($post["id_task"],$input);
        }else{
            $crud = $this->model->insert($input);
        }
        if ($this->request->isAJAX()) {
            if ($crud) {
                $resp = [
                    "message"   => "ok",
                    "code"      => "200"
                ];
                return $this->respond($resp, 200);
            }else{
                return $this->fail(implode("<br>",$this->model->errors()),201);
            }
        }else{
            // jika form non ajax
            return  redirect()->to('/table_builded');
        }
    }

    public function delete_row($id)
    {
        $delete = $this->model->delete($id);
        if ($delete) {
            $resp = [
                "message"   => "ok",
                "code"      => "200"
            ];
            return $this->respond($resp, 200);
        }else{
            return $this->fail(implode("<br>",$this->model->errors()),201);
        }
    }

    public function find_one($id)
    {
        return $this->respond($this->model->where('id', $id)->first());
    }

    public function show_form()
    {
        $data['form']   = new Formjos();
        $data['widget'] = new Formjos2();
        return view("table_builded/form",$data);
    }
}