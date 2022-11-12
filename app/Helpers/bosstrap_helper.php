<?php
// defined('BASEPATH') or exit('No direct script access allowed');

function create_input($name, $formGroup, $attr = array())
{
	$label = $name;
	if (strpos($name, "=")) {
		list($name, $label) = explode("=", $name);
	}
	if ($formGroup["formgroup"] == "true") {
		$txt = '<div class="form-group">
			<label for="' . $name . '">' . ucwords(str_replace('_', ' ', $label)) . '</label>
		' .
			form_input([
				"type" 		=> "text",
				"class"		=> "form-control",
				"name"		=> $name,
				"id"		=> $name
			], '', $attr) . '
		</div>';
	} else {
		$txt = form_input([
			"type" 		=> "text",
			"class"		=> "form-control",
			"name"		=> $name,
			"id"		=> $name
		], '', $attr);
	}
	return $txt;
}

function create_inputDate($name, $jsscript = array(), $attr = array())
{
	$label = $name;
	if (strpos($name, "=")) {
		list($name, $label) = explode("=", $name);
	}
	$txt = '<div class="form-group">' . form_label(ucwords(str_replace('_', ' ', $label)), $name) . '
              <div class="input-group date">
                  <div class="input-group-addon show_date_' . $name . '">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <div class="input-group-addon">
                    <i class="fa fa-close" onclick="$(\'#' . $name . '\').val(null)"></i>
                  </div>
                  ' .
		form_input([
			"type" 		=> "text",
			"class"		=> "form-control",
			"name"		=> $name,
			"id"		=> $name
		], '', $attr) . '
                </div>
            </div>';
	$js = 	Config('App')->footerJS;
	$js .= "\n $('#" . $name . "').datepicker(" . json_encode($jsscript) . ")";
	$js .= "\n $('.show_date_" . $name . "').click(()=>{
    			$('#" . $name . "').datepicker('show');
    		})\n";
	Config('App')->footerJS = $js;
	return $txt;
}

function create_inputDaterange($name, $jsscript = array(), $attr = array())
{
	$label = $name;
	if (strpos($name, "=")) {
		list($name, $label) = explode("=", $name);
	}
	$txt = '<div class="form-group">' . form_label(ucwords(str_replace('_', ' ', $label)), $name) . '
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  ' .
		form_input([
			"type" 		=> "text",
			"class"		=> "form-control",
			"name"		=> $name,
			"id"		=> $name
		], '', $attr)
		. '
                </div>
            </div>';
	$js = Config('App')->footerJS;
	$js .= "\n$('#" . $name . "').daterangepicker(" . json_encode($jsscript) . ")";
	Config('App')->footerJS = $js;
	return $txt;
}

function create_textarea($name, $attr = array())
{
	$label = $name;
	if (strpos($name, "=")) {
		list($name, $label) = explode("=", $name);
	}
	$txt = '<div class="form-group">
              <label for="' . $name . '">' . ucwords(str_replace('_', ' ', $label)) . '</label>
              <textarea class="form-control" name="' . $name . '" id="' . $name . '" ' . _attributes_to_string($attr) . '></textarea>
            </div>';
	return $txt;
}

function create_table($name, $modelName, $attr = array(),$ext=[])
{
	$txt = '<table name="' . $name . '" id="' . $name . '" ' . _attributes_to_string($attr) . '>
				<thead>
					<tr>
					<th><input type="checkbox" name="select_all" value="1" id="checkAll"></th>
					<th>NO</th>';
	if (is_array($modelName)) {
		$model = model("App\Models\\".$modelName['model']."");
		$header = $model->{$modelName['col']};
	} else {
		$model = model("App\Models\\$modelName");
		$header = $model->column;
	}
	foreach ($header as $key => $value) {
		if (!is_array($value)) {
			$txt .= '<th>' . strtoupper(str_replace('_', ' ', $value)) . '</th>' . "\n";
		} else {
			$txt .= '<th ' . _attributes_to_string(isset($value['attr']) ? $value['attr'] : array()) . '>' . strtoupper(isset($value['label']) ? $value['label'] : str_replace('_', ' ', $key)) . '</th>' . "\n";
		}
	}

	$txt .= '<th>#</th></tr>
				</thead>
					<tbody></tbody>
			</table>';

	return $txt;
}

function create_btnAction($act)
{
	$txt = "";
	foreach ($act as $key => $value) {
		if ($key == 'update') {
			$txt .= '<a href="javascript:void(0)" onclick="set_val_data(\'' . $value['id_key'] . '\',\''.site_url($value["url"]).'\',\'form-data\',\''.site_url($value["loadForm"]).'\')" class="btn btn-xs btn-light" title="Edit">
	                            <i class="fa fa-pencil-alt"></i>
	                        </a>';
		} elseif ($key == 'delete') {
			$txt .= '	<a href="javascript:void(0)" onclick="delete_row_data(\'' . $value['id_key'] . '\',\''.site_url($value["url"]).'\')" class="btn btn-xs  btn-danger" title="Delete">
								<i class="fas fa-trash-alt"></i>
	                        </a>';
		} else {
			$txt .= ' <a href="javascript:void(0)" onclick="' . $value['btn-act'] . '" class="btn btn-xs ' . $value['btn-class'] . '" title="' . $key . '">
								<i class="' . $value['btn-icon'] . '"></i>
	                        </a>';
		}
	}
	return $txt;
}

function create_tableData($attr = array())
{
	$txt = '<table name="' . $attr['name'] . '" id="' . $attr['name'] . '" class="table table-bordered"' . (isset($attr['ext']) ? _attributes_to_string($attr['ext']) : '') . '>
				<thead>
					<tr>
					<th>NO</th>';
	
	$model = model("App\Models\\".$attr['model']."");
	$header = $model->get_column();
	foreach ($header as $key => $value) {
		if (!is_array($value)) {
			$txt .= '<th>' . strtoupper(str_replace('_', ' ', $value)) . '</th>' . "\n";
		} else {
			$txt .= '<th ' . _attributes_to_string(isset($value['attr']) ? $value['attr'] : array()) . '>' . strtoupper(isset($value['label']) ? $value['label'] : str_replace('_', ' ', $key)) . '</th>' . "\n";
		}
	}

	$txt .= '</tr>
				</thead>
					<tbody>';
	foreach ($attr['data'] as $key => $value) {
		$txt .= "<tr>
					<td>" . ($key + 1) . "</td>
			";
		foreach ($header as $key => $rs) {
			$txt .= "<td>" . $value->{$rs} . "</td>";
		}
		$txt .= "</tr>";
	}

	$txt .= '</tbody>
			</table>';

	return $txt;
}

function modal_open($id, $header, $size = "", $attr = array(), $autohide = true)
{
	$txt = '<div class="modal fade" id="' . $id . '">
	        <div class="modal-dialog ' . $id . ' ' . $size . '" ' . _attributes_to_string($attr) . '>
	          <div class="modal-content ' . $id . '">';

	if ($autohide) {
		$txt .= '
		<script>
		$("#' . $id . '").on(\'hidden.bs.modal\',function(){
			$(this).find(\'.modal-body\').html("");
			});
		</script>';
	}
	$txt .= '
	<div class="modal-header ' . $id . '">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span></button>
		<h4 class="modal-title">' . $header . ' </h4></div>
	<div class="modal-body ' . $id . '">';
	return $txt;
}

function modal_close($footer = null, $autohide = true)
{
	$txt = '</div>
	            <div class="modal-footer">';
	if ($footer) {
		foreach ($footer as $key => $value) {
			$txt .= $value . "\n";
		}
	}
	$txt .= '</div>
	          </div>
	        </div>
	        </div>';
	return $txt;
}

function create_select($data)
{
	$label = $data['attr']['name'];
	if (strpos($data['attr']['name'], "=")) {
		list($data['attr']['name'], $label) = explode("=", $data['attr']['name']);
	}

	$txt = '<div class="form-group">
              <label for="' . $data['attr']['name'] . '">' . ucwords(str_replace('_', ' ', $label)) . '</label>';
	$txt .= '<select style="width:100% !important" ' . _attributes_to_string($data['attr']) . '>';


	if (isset($data['model'])) {
		$model = key($data['model']);
		$model = model("App\Models\\$model");
		$txt .= "<option value=\"\">--</option>\n";
		if (is_array(current($data['model']))) {
			$dataSelect = $model->{($data['model'][$model][0])}($data['model'][$model][1]);
		} else {
			$dataSelect = $model->{current($data['model'])}();
		}
		foreach ($dataSelect as $key => $value) {
			$selected = "";
			if (!empty($data["selected"]) && ($value->{$data["model"]['column'][0]} === $data["selected"])) {
				$selected = "selected";
			}
			$txt .= "<option $selected value =\"" . $value->{$data["model"]['column'][0]} . "\">" . $value->{$data["model"]['column'][1]} . "</option>\n";
		}
	} elseif (isset($data['option'])) {
		foreach ($data['option'] as $key => $value) {
			$selected = "";
			if (is_array($value)) {
				if (!empty($data["selected"]) && $value['id'] == $data["selected"]) {
					$selected = "selected";
				}
				$txt .= "<option $selected value=\"" . $value['id'] . "\">" . $value['text'] . "</option>\n";
			} else {
				if (!empty($data["selected"]) && $value == $data["selected"]) {
					$selected = "selected";
				}
				$txt .= "<option $selected>" . $value . "</option>\n";
			}
		}
	}
	$txt .= "</select>\n</div>";
	return $txt;
}

function array_to_json($data)
{
	$var = json_encode($data);
	preg_match_all('/\"function.*?\"/', $var, $matches);
	foreach ($matches[0] as $key => $value) {
		$newval = str_replace(array('\n', '\r', '\t', '\/'), array(PHP_EOL, "\t", ''), trim($value, '"'));
		$var = str_replace($value, $newval, $var);
	}
	return $var;
}

function create_select2($data)
{
	$txt = create_select($data);
	if (strpos($data['attr']['name'], "=")) {
		list($data['attr']['name'], $label) = explode("=", $data['attr']['name']);
	}
	$js = Config('App')->footerJS;
	$js .= "\n$('#" . $data['attr']['id'] . "').select2(" . json_encode((isset($data['select2']) ? $data['select2'] : [])) . ")";
	Config('App')->footerJS = $js;
	return $txt;
}

function create_inputMask($name, $jsscript = array(), $attr = array())
{
	$txt = create_input($name, $attr);
	if (strpos($name, "=")) {
		list($name, $label) = explode("=", $name);
	}

	$js = Config('App')->footerJS;
	// $js .= "\n$('#".$name."').inputmask(\"".$jsscript[0].'",'.json_encode(isset($jsscript[1])?$jsscript[1]:[]).")";
	if (is_array($jsscript)) {
		$js .= "\n$('#" . $name . "').inputmask(\"" . $jsscript[0] . '",' . json_encode($jsscript[1]) . ")";
	} else {
		$js .= "\n$('#" . $name . "').inputmask(\"" . $jsscript . "\")";
	}
	Config('App')->footerJS = $js;
	return $txt;
}

function create_inputFile($name, $jsscript = array(), $attr = array())
{
	$txt = '<div class="form-group">
	            <div class="file-loading">
	                <input type="file" name="' . $name . '" id="' . $name . '" data-upload-url="#">
	            </div>
	            <div id="errorBlock" class="help-block"></div>
	        </div>';
	$js = Config('App')->footerJS;
	if (is_array($jsscript)) {
		$js .= "\n
    		$(document).ready(function() {
    			$('#" . $name . "').fileinput(\"" . json_encode($jsscript) . ");
    		});";
	} else {
		$js .= "\n$('#" . $name . "').fileinput()";
	}
	Config('App')->footerJS = $js;
	return $txt;
}

function label_status($condition)
{
	return "<span class=\"label " . $condition['class'] . "\">" . $condition['text'] . "</span>";
}

function _attributes_to_string($attributes)
{
	if (empty($attributes)) {
		return '';
	}

	if (is_object($attributes)) {
		$attributes = (array) $attributes;
	}

	if (is_array($attributes)) {
		$atts = '';

		foreach ($attributes as $key => $val) {
			$atts .= ' ' . $key . '="' . $val . '"';
		}

		return $atts;
	}

	if (is_string($attributes)) {
		return ' ' . $attributes;
	}

	return FALSE;
}
