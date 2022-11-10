
<div class="card border-success">
    <div class="card-body">
        <?=form_open("karyawan/save",["method"=>"post","id"=>"form_karyawan"])?>
        <?= form_hidden("id") ?>
        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "nama",
                            "label"     => "nama"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "tanggal",
                            "label"     => "tanggal"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "jenis_kelamin",
                            "label"     => "jenis_kelamin"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "alamat",
                            "label"     => "alamat"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "gaji",
                            "label"     => "gaji"
                        ]);
                        ?>
                        
        <?= $form->endForm() ?>
    </div>
    <div class="card-footer bg-success">
        <?= form_button([
            "name"      => "simpan",
            "class"     => "btn btn-info simpan",
            "type"      => "button",
            "onclick"   => "$('#form_karyawan').submit()"
        ], "SIMPAN") ?>
        <?= form_button([
            "name"          => "cancel",
            "class"         => "btn btn-danger cancel-form",
            "type"          => "button",
            "data-target"   => "list-data",
            "data-close"    => "form-data",
        ], "BATAL") ?>
    </div>
</div>