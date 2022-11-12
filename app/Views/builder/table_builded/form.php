
<div class="card border-success">
    <div class="card-body">
        <?=form_open("table_builded/save",["method"=>"post","id"=>"form_table_builded"])?>
        <?= form_hidden("id_task") ?>
        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "table_name",
                            "label"     => "table_name"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "controller",
                            "label"     => "controller"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "model",
                            "label"     => "model"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "views",
                            "label"     => "views"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "user_created",
                            "label"     => "user_created"
                        ]);
                        ?>
                        
                        <?=
                        $form->form_group([
                            "type"      => "input",
                            "id"        => "created_at",
                            "label"     => "created_at"
                        ]);
                        ?>
                        
        <?= $form->endForm() ?>
    </div>
    <div class="card-footer bg-success">
        <?= form_button([
            "name"      => "simpan",
            "class"     => "btn btn-info simpan",
            "type"      => "button",
            "onclick"   => "$('#form_table_builded').submit()"
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