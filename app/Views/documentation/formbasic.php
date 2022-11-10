<?php
use App\Libraries\Formjos;
$form = new Formjos();
?>
<?= $this->extend('themes/header') ?>
<?=Config('App')->footerJs?>
<?= $this->section('content') ?>
<h2>
    HALAMAN DOKUMENTASI BUILDER FORM BASIC
</h2>
<?=
    $form->form_group([
        "type"      => "input",
        "id"        => "input_field",
        "label"     => "FORM INPUT"
    ]);?>
<?=
    $form->form_group([
        "type"      => "select",
        "id"        => "select_data",
        "label"     => "FORM SELECT DATA",
        "option"    => [
            "data"  => ["AKU","KAMU"]
        ]
    ]);?>
<?=
    $form->form_group([
        "type"      => "select",
        "id"        => "select_model",
        "label"     => "FORM SELECT MODEL",
        "option"    => [
            "data"  => [
                "model"     => "CobaModel",
                "column"    => [
                    "menu_id",
                    "menu_name"
                ]
            ]
        ]
    ]);?>
<?=
    $form->form_group([
        "type"      => "textArea",
        "id"        => "text_area",
        "label"     => "FORM TEXT AREA",
    ]);?>
<?=
    $form->form_group([
        "type"      => "file",
        "id"        => "input_file",
        "label"     => "FORM FILE UPLOAD"
    ]);?>
<?= $this->endSection() ?>