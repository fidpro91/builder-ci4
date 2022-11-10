<?php
namespace App\Libraries;
use App\Libraries\Formjos;

class Formjos2 extends Formjos
{
    protected $form;
    protected $formId;
    protected $formLabel;
    protected $scripts;

    function __construct() {
        // $this->include_scripts();
    }

    public function select2($attr)
    {
        if (isset($attr['option']['extra'])) {
            $attr['option']['extra'] = array_merge($attr['option']['extra'],["style"=>"width:100%"]);
        }else{
            $attr['option']['extra'] = ["style"=>"width:100%"];
        }
        $this->form = $this->dropDown($attr['option'],$attr['id']);
        $this->form .= "<script>$(\"#".$attr['id']."\").select2(". json_encode((isset($attr['option']['select2']) ? $attr['option']['select2'] : [])) .");</script>";
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function inputCustom($attr)
    {
        $defaultAttr = [
            "class"		=> "form-control"
        ];

        $this->form = form_input($defaultAttr, '', $attr);
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function switchBosstrap($attr)
    {
        $defaultAttr = [
            "type"		=> "checkbox",
            "checked"   => "true",
            "name"      => $attr['id']
        ];
        $this->form     = form_input($defaultAttr, '', $attr);
        $this->form     .= '<script>$("#'.$attr['id'].'").bootstrapSwitch()</script>';
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function inputMask($attr)
    {
        $this->form     = $this->input($attr);
        $this->form     .= "<script>";
        if (is_array($attr['js'])) {
            $this->form .= "\n$('#" . $attr['id'] . "').inputmask(\"" . $attr['js'][0] . '",' . json_encode($attr['js'][1]) . ")";
        } else {
            $this->form .= "\n$('#" . $attr['id'] . "').inputmask(\"" . $attr['js'] . "\")";
        }
        $this->form     .= '</script>'."\n";
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function datePicker($attr)
    {
        $defaultAttr = [
            "type"		=> "text",
            "class"     => "form-control",
        ];
        $this->form     = "<div class='input-group'>";
        $this->form     .= form_input($defaultAttr, '', $attr);
        $this->form     .= '<div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>';
        $this->form     .= '<script>
                                $("#'.$attr['id'].'").daterangepicker({
                                    singleDatePicker: true,
                                    showDropdowns: true
                                });
                            </script>';
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function daterangePicker($attr)
    {
        $this->scripts = 
        $defaultAttr = [
            "type"		=> "text",
            "class"     => "form-control",
        ];
        $this->form     = "<div class='input-group'>";
        $this->form     .= form_input($defaultAttr, '', $attr);
        $this->form     .= '<div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>';
        $this->form     .= '<script>
                                $("#'.$attr['id'].'").daterangepicker({
                                    showDropdowns: true
                                });
                            </script>';
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function daterangePickerCalender($attr)
    {
        $this->scripts = 
        $defaultAttr = [
            "type"		=> "text",
            "class"     => "form-control",
        ];
        $this->form     = "<div class='input-group'>";
        $this->form     .= form_input($defaultAttr, '', $attr);
        $this->form     .= '<div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>';
        $this->form     .= '<script>
                                $("#'.$attr['id'].'").daterangepicker({
                                    ranges: {
                                        "Today": [moment(), moment()],
                                        "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                                        "This Month": [moment().startOf("month"), moment().endOf("month")],
                                        "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                                    },
                                    alwaysShowCalendars: true
                                });
                            </script>';
        $this->formId    = $attr['id'];
        $this->formLabel = ucwords(isset($attr['label'])?$attr['label']:str_replace('_', ' ', $attr['id']));
        return $this;
    }

    public function ckeditor($attr)
    {
        $this->form = $this->textArea($attr);
        $this->form .= "
        <script data-sample=\"1\">
        CKEDITOR.replace('".$attr['id']."', {
                height: 150
            });
        </script>";
        return $this;
    }

    public function render()
    {
        return $this->form;
    }

    public function renderForm()
    {   $render = '<div class="form-group">
            <label for="' . $this->formId . '">' .$this->formLabel. '</label>';
        $render .= $this->form."</div>";

        return $render;
    }

    public function init()
    {
        //css
        $css = 
        link_tag('assets/themes/libs/daterangepicker/daterangepicker.css')."\n".
        link_tag('assets/themes/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')."\n".
        link_tag('assets/themes/libs/select2/dist/css/select2.min.css')."\n".
        link_tag('assets/themes/libs/ckeditor/samples/css/samples.css')."\n".
        link_tag('assets/dist/css/style.min.css');
        //plugins javascripts
        $this->scripts = 
        script_tag('assets/themes/libs/select2/dist/js/select2.full.min.js')."\n".
        script_tag('assets/themes/libs/select2/dist/js/select2.min.js').
        script_tag('assets/themes/libs/moment/moment.js')."\n".
        script_tag('assets/themes/libs/daterangepicker/daterangepicker.js')."\n".
        script_tag('assets/themes/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')."\n".
        script_tag('assets/themes/libs/ckeditor/ckeditor.js')."\n".
        script_tag('assets/themes/libs/input-mask/dist/jquery.inputmask.js')."\n".
        script_tag('assets/themes/libs/input-mask/dist/bindings/inputmask.binding.js')."\n".
        '<script>
		Inputmask.extendAliases({
			  "IDR": {
			    alias: "decimal",
			    allowMinus: false,
				radixPoint: ".",
				autoGroup: true,
				groupSeparator: ",",
				groupSize: 3,
				autoUnmask: true,
				removeMaskOnSubmit:true
			  }
			});
		</script>'."\n";
        /* Config('App')->headerCSS = $css.Config('App')->headerCSS;
        Config('App')->footerJs = Config('App')->footerJs."\n".$this->scripts; */
        echo $css."\n".$this->scripts;
    }
}