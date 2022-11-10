<?php
namespace App\Controllers\Builder;
use App\Controllers\Core\CoreController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\BuilderModel;
use App\Libraries\Formjos;
use App\Libraries\Formjos2;

class Builderform extends CoreController
{
    use ResponseTrait;
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['form']   = new Formjos();
        $data['widget'] = new Formjos2();
        return $this->get_theme('builder/index',$data,get_class($this));
    }

    public function get_field_table($table)
    {
        $data['form']       = new Formjos();
        $data["fieldTable"] = $this->db->getFieldData($table);
        return view("builder/list_form",$data);
    }

    public function build_form()
    {
        $post = $this->request->getPost();
        $data = $this->db->getFieldData($post['list_table']);
        if (isset($post["is_controller"])) {
            $this->_createController($post['list_table'],$data);
        }
        if (isset($post["is_model"])) {
            $this->_createModel($post['list_table'],$data);
        }
        
        if (isset($post["is_view"])) {
            $this->_createModel($post['list_table'],$data);
            $patchDir = APPPATH.'Views/'.($post['list_table']);
            if (!is_dir($patchDir)) {
                mkdir($patchDir);
            }else{
                array_map('unlink', array_filter( 
                    (array) array_merge(glob($patchDir."/*"))));
            }
            $this->_createViewIndex($post['list_table'],$patchDir);
            $this->_createViewForm($post['list_table'],$post,$data,$patchDir);
        }
        $resp = [
            "message"   => "ok",
            "resp"      => [
                "url"   => "<a href='".base_url($post['list_table'])."' target=\"_blank\">".base_url($post['list_table'])."</a>"
            ]
        ];
        return $this->respond($resp);
    }

    private function _createController($tableName,$data)
	{
		$className = $tableName;

		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$file = file_get_contents(WRITEPATH."builder/controller.txt");
		$file = str_replace('$className', ucfirst($className), $file);
		$file = str_replace('$urlFirst', strtolower($className), $file);
		$file = str_replace('$modelName', ucwords($tableName."Model"), $file);
		foreach ($data as $key => $value) {
			if ($value->primary_key > 0) {
				$file = str_replace('$primaryKey',($value->name), $file);
			}
		}
		write_file(APPPATH.'Controllers/'.ucfirst($className).'.php',$file,"wa+");

	}

    private function _createViewForm($tableName,$post,$field,$patchDir)
	{
		$className = $tableName;

		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		if ($post['form_type'] == 'FORM-BASIC') {
            $file = file_get_contents(WRITEPATH."builder/views/v_form.txt");
        }else {
            $file = file_get_contents(WRITEPATH."builder/views/v_form_ajax.txt");
        }
        $widget = ['Date','Switch','Inputmask'];
        $formBuild="";
        foreach ($field as $key => $value) {
			if ($value->primary_key > 0) {
				$file = str_replace('$primaryKey',($value->name), $file);
			}else{
                if (in_array($post[$value->name],$widget)) {
                    $file = str_replace('$initialWidget',
                    '<?php'."\n".'
                        $widget->init();
                    ?>'."\n".''
                    , $file);
                }
                switch ($post[$value->name]) {
                    case 'Textfield':
                        $formBuild .= '
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "'.$value->name.'",
                            "label"     => "'.$value->name.'"
                        ]);
                        ?>
                        ';
                        break;
                    case 'Textarea':
                        $formBuild .= '
                        <?=
                        $form->form_group([
                            "type"      => "textArea",
                            "id"        => "'.$value->name.'",
                            "label"     => "'.$value->name.'",
                        ]);?>
                        ';
                        break;
                    case 'Select':
                        $formBuild .= '
                        <?=
                        $form->form_group([
                            "type"      => "select",
                            "id"        => "'.$value->name.'",
                            "label"     => "'.$value->name.'",
                            "option"    => [
                                "data"  => ["OPTION1","OPTION2"]
                            ]
                        ]);?>
                        ';
                        break;
                    case 'Date':
                        $formBuild .= '
                        <?=
                            $widget->datePicker([
                                "id"                => "'.$value->name.'",
                                "label"             => "'.$value->name.'",
                            ])->renderForm();
                        ?>
                        ';
                        break;
                    case 'Switch':
                        $formBuild .= '
                        <?=
                            $widget->switchBosstrap([
                                "id"                => "'.$value->name.'",
                                "label"             => "'.$value->name.'",
                                "data-on-color"     => "success",
                                "data-off-color"    => "info",
                                "data-on-text"      => "Yes",
                                "data-off-text"     => "No"
                            ])->renderForm();
                        ?>
                        ';
                        break;
                    case 'Inputmask':
                        $formBuild .= '
                        <?=
                            $widget->inputMask([
                                "id"        => "'.$value->name.'",
                                "label"     => "'.$value->name.'",
                                "js"        => "IDR"
                            ])->renderForm();
                        ?>
                        ';
                        break;
                    case 'Hidden':
                        $formBuild .= '
                        <?= form_hidden("'.$value->name.'") ?>
                        '."\n";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
		}
        $file = str_replace('$initialWidget','', $file);
		$file = str_replace('$tableName', strtolower($className), $file);
		$file = str_replace('$formHtml', $formBuild, $file);
		$file = str_replace('$modelName', ucwords($tableName."Model"), $file);
		write_file($patchDir.'/form.php',$file,"wa+");

	}

    private function _createViewIndex($tableName,$patchDir)
	{
		$className = $tableName;

		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$file = file_get_contents(WRITEPATH."builder/views/v_index.txt");
		$file = str_replace('$tableName', strtolower($className), $file);
		$file = str_replace('$modelName', ucwords($tableName."Model"), $file);
		write_file($patchDir.'/index.php',$file,"wa+");

	}

    private function _createModel($tableName,$data)
	{
		$className = $tableName;
		if (strpos($tableName,'.') > 0) {
			$tb = explode('.', $tableName);
			$className = $tb[1];
		}
		$file = file_get_contents(WRITEPATH."builder/model.txt");
		$column = "\n";
		$rule = "";
		$pkey = null;
        
		foreach ($data as $key => $value) {
			$column .= "\t\t\"$value->name\",\n";
			if ($key>0 and $value->primary_key != '1') {
				$rule .= "\t\t";
			}
            if ($value->primary_key>0) {
				$pkey = $value->name;
			}
			/* if ($value->name_key == 'PRIMARY KEY' || $value->name_key == 'PRI') {
				$pkey = $value->name;
			} */
			// if ($value->extra == '' and ($value->name_key != 'PRI' || $value->name_key != 'PRIMARY KEY')) {
			if (($value->primary_key != '1')) {
				$rule .= '"'.$value->name.'" => "trim|';
				if ($value->type == 'int' || $value->type == 'bigint' || $value->type == 'integer' || $value->type == 'smallint') {
					$rule .= 'integer|';
				}elseif ($value->type == 'float' || $value->type == 'double precision') {
					$rule .= 'numeric|';
				}
				// if ($value->nullable == 'NO') {
				if ($value->nullable == null) {
					$rule .= 'required|';
				}
				$rule = rtrim($rule,'|')."\",\n";
			}
		}
		$rule = rtrim($rule,",\n");
		$file = str_replace('$modelName',ucfirst($className."Model"), $file);
		$file = str_replace('$tableName',($tableName), $file);
		$file = str_replace('$keyPrimary',($pkey), $file);
		$file = str_replace('$listField',($column), $file);
		$file = str_replace('$validationField',($rule), $file);
		write_file(APPPATH.'Models/'.ucfirst($className."Model").'.php',$file,"wa+");

	}
}