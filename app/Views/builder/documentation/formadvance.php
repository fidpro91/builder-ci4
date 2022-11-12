<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<?php
use App\Libraries\Formjos2;
$widget = new Formjos2();
$widget->init();
?>
<h2>
    HALAMAN DOKUMENTASI BUILDER FORM ADVANCE
</h2>
<div class="row">
    <div class="col-md-6">
        <?=
            $widget->select2([
                "type"      => "select",
                "id"        => "select2_model",
                "label"     => "FORM SELECT2 WITH MODEL",
                "option"    => [
                    "data"  => [
                        "model"     => "builder\DocumentationModel",
                        "column"    => [
                            "menu_id",
                            "menu_name"
                        ]
                    ]
                ]
            ])->renderForm();?>
        <?=
            $widget->select2([
                "type"      => "select",
                "id"        => "select2_multi_model",
                "label"     => "FORM SELECT2 MULTI WITH MODEL",
                "option"    => [
                    "data"  => [
                        "model"     => "builder\DocumentationModel",
                        "column"    => [
                            "menu_id",
                            "menu_name"
                        ]
                    ],
                    "extra" => [
                        "multiple"  => true
                    ]
                ]
            ])->renderForm();?>
        <?=
            $widget->inputCustom([
                "type"      => "date",
                "id"        => "input_date",
                "label"     => "FORM INPUT DATE"
            ])->renderForm();
        ?> 
        <?=
            $widget->inputCustom([
                "type"      => "number",
                "id"        => "input_numeric",
                "label"     => "FORM INPUT NUMERIC"
            ])->renderForm();
        ?>
        <?=
            $widget->inputMask([
                "id"        => "input_mask",
                "label"     => "FORM INPUT MASK",
                "js"        => "IDR"
            ])->renderForm();
        ?>
        <?=
            $widget->switchBosstrap([
                "id"                => "switch_bosstrap",
                "label"             => "FORM INPUT SWITCH",
                "data-on-color"     => "success",
                "data-off-color"    => "info",
                "data-on-text"      => "Yes",
                "data-off-text"     => "No"
            ])->renderForm();
        ?>
    </div>
    <div class="col-md-6">
        <?=
            $widget->datePicker([
                "id"                => "date_picker",
                "label"             => "FORM INPUT DATEPICKER",
            ])->renderForm();
        ?>
        <?=
            $widget->daterangePicker([
                "id"                => "date_range_picker",
                "label"             => "FORM INPUT DATERANGEPICKER",
            ])->renderForm();
        ?>

        <?=
            $widget->daterangePickerCalender([
                "id"                => "date_range_picker_calender",
                "label"             => "FORM INPUT DATERANGEPICKERCALENDER",
            ])->renderForm();
        ?>
    </div>
</div>
<div class="col-md-12">
<?=
    $widget->ckeditor([
        "type"      => "textArea",
        "id"        => "text_area"
    ])->render();
?>
</div>
<?= $this->endSection() ?>