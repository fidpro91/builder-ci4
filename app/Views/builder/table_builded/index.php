<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<div class="card" id="list-data">
    <div class="card-body">
        <?= $dataTable->renderAjax([
            "id"            => "table_table_builded",
            "model"         => "Builder\Table_buildedModel",
            "dataTable"     => '
            { 
                "processing": true, 
                "serverSide": true, 
                "order": [], 
                "scrollX": true,
                "ajax": {
                    "url": "' . site_url('builder/table_builded/get_data') . '",
                    "type": "POST"
                },
                "columnDefs": [
                {
                "targets": [0,1,-1],
                "searchable": false,
                "orderable": false,
                },
                {
                    "targets": [0,-1],
                    "visible": false,
                    },
                {
                "targets": 0,
                "className": "dt-body-center",
                "render": function (data, type, full, meta){
                    return "<input type=\"checkbox\" name=\"id[]\" value=\"" + $("<div/>").text(data).html() +"\">";
                }
                }], 
            }'
        ]) ?>
    </div>
</div>
<?= $this->endSection() ?>