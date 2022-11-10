<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<?php
$widget->init();
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body data-form">
                <div class="row">
                    <div class="col-md-4">
                        <?=
                        $widget->select2([
                            "type"      => "select",
                            "id"        => "list_table",
                            "label"     => "List Table",
                            "option"    => [
                                "data"  => [
                                    "model"      => "BuilderModel",
                                    "custom"     => "get_all_table"
                                ]
                            ]
                        ])->renderForm(); ?>

                        <?=
                        $widget->switchBosstrap([
                            "id"                => "is_controller",
                            "label"             => "Controller",
                            "data-on-color"     => "success",
                            "data-off-color"    => "info",
                            "data-on-text"      => "Yes",
                            "data-off-text"     => "No"
                        ])->renderForm();
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?=
                        $form->form_group([
                            "type"      => "select",
                            "id"        => "form_type",
                            "label"     => "form_type",
                            "option"    => [
                                "data" => ["FORM-BASIC", "FORM-AJAX"]
                            ]
                        ]); ?>
                        <?=
                        $widget->switchBosstrap([
                            "id"                => "is_model",
                            "label"             => "Model",
                            "data-on-color"     => "success",
                            "data-off-color"    => "info",
                            "data-on-text"      => "Yes",
                            "data-off-text"     => "No"
                        ])->renderForm();
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "input_field",
                            "label"     => "menu_name"
                        ]); ?>
                        <?=
                        $widget->switchBosstrap([
                            "id"                => "is_view",
                            "label"             => "View",
                            "data-on-color"     => "success",
                            "data-off-color"    => "info",
                            "data-on-text"      => "Yes",
                            "data-off-text"     => "No"
                        ])->renderForm();
                        ?>
                    </div>
                </div>






            </div>
            <div class="card-footer">
                <?= form_button([
                    "name"      => "btn-create",
                    "class"     => "btn btn-info",
                    "type"      => "button",
                    "onclick"   => "get_field()"
                ], "Create") ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Design Form View</h5>
                <span class="respondse"></span>
                <div id="formview"></div>
            </div>
            <div class="card-footer">
                <?= form_button([
                    "name"      => "btn-builder",
                    "id"        => "btn-builder",
                    "class"     => "btn btn-success",
                    "type"      => "submit",
                    "disabled"  => "true",
                    "onclick"   => "$('#form_builder').submit()"
                ], "Build") ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(()=>{
        console.log();
    })
    function get_field() {
        $("#formview").load("<?= site_url("builder/builderform/get_field_table") ?>/" + $("#list_table").val(), () => {
            $("#btn-builder").attr("disabled", false);
        });
    }
</script>
<?= $this->endSection() ?>