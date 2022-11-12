<?php
namespace App\Controllers;
use App\Controllers\Core\CoreController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BiodataModel;
use App\Libraries\Datatable;
use App\Libraries\Formjos;
use App\Libraries\Formjos2;

class Biodata extends CoreController
{
    use ResponseTrait;
    protected $model;
    public function __construct()
    {
        $this->model = new BiodataModel();
    }

    public function index()
    {
        $data['dataTable'] = new Datatable();
        return $this->get_theme('biodata/index',$data,get_class($this));
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
                    "name"          => "BiodataModel",
                    "resource"      => "get_dataTable"
                ],
                "rightTool"         => function($param){
                    return create_btnAction([
                        "update"=>[
                            "id_key"        => $param["id_key"],
                            "url"           => "biodata/find_one",
                            "loadForm"      => "biodata/show_form"
                        ],
                        "delete"=>[
                            "id_key"  => $param["id_key"],
                            "url"     => "biodata/delete_row"
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

        if ($post["id"]) {
            $crud = $this->model->update($post["id"],$input);
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
            return  redirect()->to('/biodata');
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
        return view("biodata/form",$data);
    }
}