<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<div class="card border-success">
    <div class="card-body">
        <?= $form->formAjax_open([
            "extra"     => ["id" => "form_git"],
            "url"       => "builder/gitcontroller/git_run",
            "data"      => "$(this).serialize()",
            "onSuccess" => 'function(data) {
                Swal.fire(data.message, "", "success");
                location.reload(true);
            }',
            "onFail"    => 'function(jqXHR, textStatus, errorThrown) {
                if (errorThrown == "timeout") {
                    location.reload(true);
                } else {
                    alert(errorThrown);
                }
            }',
            "timeOut"   => 5000
        ]) ?>
        <?=
        $form->form_group([
            "type"      => "input",
            "id"        => "branch_name",
            "label"     => "branch_name"
        ]);
        ?>
        <?=
        $form->form_group([
            "type"      => "input",
            "id"        => "commit",
            "label"     => "commit"
        ]);
        ?>
        <?=
        $form->form_group([
            "type"      => "select",
            "id"        => "git_type",
            "label"     => "Git Action",
            "option"    => [
                "data"  => ["push", "pull"]
            ]
        ]); ?>
        <?= $form->endForm() ?>
    </div>
    <div class="card-footer bg-success">
        <?= form_button([
            "name"      => "Pull",
            "class"     => "btn btn-info simpan",
            "type"      => "button",
            "onclick"   => "$('#form_git').submit()"
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
<?= $this->endSection() ?>