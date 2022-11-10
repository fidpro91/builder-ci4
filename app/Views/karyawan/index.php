<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<div class="form-data" id="form-data">
</div>
<div class="card" id="list-data">
    <h5 class="card-header d-flex justify-content-between align-items-center">
        DATA <?=$pageName?>
        <button type="button" data-target="form-data" data-close="list-data" data-url="<?=site_url("karyawan/show_form")?>" class="btn btn-primary add-form">Add</button>
    </h5>
    <div class="card-body">
        <?= $dataTable->renderAjax([
            "id"            => "table_karyawan",
            "model"         => "KaryawanModel",
            "dataTable"     => '
            { 
                "processing": true, 
                "serverSide": true, 
                "order": [], 
                "scrollX": true,
                "ajax": {
                    "url": "' . site_url('karyawan/get_data') . '",
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
        ]) ?>
    </div>
</div>
<?= $this->endSection() ?>