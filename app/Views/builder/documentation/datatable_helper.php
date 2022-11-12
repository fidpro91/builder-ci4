<?php
use App\Libraries\Datatable;
$dataTable = new Datatable();
?>
<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<h2>
    HALAMAN DOKUMENTASI BUILDER DATATABLE
</h2>
<H4>DATA TABLE</H4>
<?=$dataTable->render([
    "id"        =>"table_menu",
    "model"     => "builder\DocumentationModel"
])?>
<H4>DATA TABLE AJAX</H4>
<?=$dataTable->renderAjax([
    "id"            =>"table_menu_2",
    "model"         => "builder\DocumentationModel",
    "dataTable"     => '
    { 
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "scrollX": true,
        "ajax": {
            "url": "'.site_url('builder/documentation/data_row').'",
            "type": "POST"
        },
        "columnDefs": [
        {
          "targets": [0,1,-1],
           "searchable": false,
           "orderable": false,
         },
        {
           "targets": 0,
           "className": "dt-body-center",
           "render": function (data, type, full, meta){
               return "<input type=\"checkbox\" name=\"id[]\" value=\"" + $("<div/>").text(data).html() +"\">";
           }
        }], 
    }'
])?>
<?= $this->endSection() ?>