<?php
namespace App\Libraries;
class Formjos
{
    private $id;

    public function input($attr=[])
    {
        return form_input([
			"type" 		=> "text",
			"class"		=> "form-control",
            "id"        => $attr["id"],
            "name"      => $attr["id"],
		], '', $attr);
    }

    public function form_group($attr)
    {
        $txt = '<div class="form-group">
			<label for="' . $attr['id'] . '">' . ucwords(str_replace('_', ' ', $attr['label'])) . '</label>
		';
        switch ($attr['type']) {
            case 'input':
                $txt .= $this->input((isset($attr)?$attr:null));    
            break;

            case 'select':
                $txt .= $this->dropDown($attr['option'],$attr['id']);  
            break;
            
            case 'textArea':
                $txt .= $this->textArea($attr);  
            break;

            case 'file':
                $txt .= $this->fileUpload($attr);  
            break;
            
            default:
                # code...
                break;
        }

        $txt .= "</div>";

        return $txt;
    }

    public function dropDown($attr,$id=null)
    {
        $dataDropdown=$attr['data'];
        if (isset($attr['data']['model'])) {
            $data = $attr['data'];
            $model = model("App\Models\\".$data["model"]."");
            $filter = [];
            if (isset($data['custom'])) {
                $dataSelect = $model->{$data['custom']}($filter);
            }else{
                $dataSelect = $model->where($filter)->findAll();
            }
            $dataDropdown = [];
            foreach ($dataSelect as $key => $value) {
               if (isset($data['column'])) {
                   $dataDropdown[$value->{$data['column'][0]}] = $value->{$data['column'][1]};
               }else{
                    $dataDropdown[$value] = $value;
               }
            }
        }
        $defaultAttr = [
            "class"     => "form-control",
            "id"        => $id??$attr['id'],
        ] ;
        if (isset($attr['extra'])) {
            $defaultAttr = array_merge($defaultAttr,$attr['extra']);
        }
        $this->id = $id??$attr['id'];
        return form_dropdown($id??$attr['id'], $dataDropdown, '', _attributes_to_string($defaultAttr));
    }

    public function textArea($attr)
    {
        $defaultAttr = [
            "class"     => "form-control",
            "id"        => $attr['id'],
            "name"      => $attr['id'],
        ] ;
        if (isset($attr['option'])) {
            $defaultAttr=array_merge($defaultAttr,$attr['option']);
        }
        return form_textarea($defaultAttr);
    }

    public function fileUpload($attr)
    {
        $defaultAttr = [
            "class"		=> "form-control-file"
        ];

        return form_input($attr, '', $defaultAttr);
    }

    public function formAjax_open($attr)
    {
        $form = form_open('',$attr["extra"]).
        '<script>
        $("#'.$attr["extra"]['id'].'").on("submit",function(){
            Swal.fire({
                title: "Simpan Data?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        "type": "post",
                        "data": '.$attr['data'].',
                        "dataType": "json",
                        "url": "'.base_url($attr['url']).'",
                        "success": '.$attr['onSuccess'].',
                        timeout: '.$attr["timeOut"].',
                    });
                }
            })
          return false
        });
        </script>';
        return $form;
    }

    public function endForm()
    {
        return "</form>";
    }

}