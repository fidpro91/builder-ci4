<div class="card border-success">
    <div class="card-body">
        <?= form_open("builder/user_developer/save", ["method" => "post", "id" => "form_user_developer"]) ?>
        <?= form_hidden("user_id") ?>
        <?=
        $form->form_group([
            "type"      => "input",
            "id"        => "username_developer",
            "label"     => "username_developer"
        ]);
        ?>
        <?=
        $form->form_group([
            "type"      => "input",
            "id"        => "password_developer",
            "label"     => "password_developer"
        ]);
        ?>
        <?= $form->endForm() ?>
    </div>
    <div class="card-footer bg-success">
        <?= form_button([
            "name"      => "simpan",
            "class"     => "btn btn-info simpan",
            "type"      => "button",
            "onclick"   => "$('#form_user_developer').submit()"
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