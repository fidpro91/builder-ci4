<?= $form->formAjax_open([
    "extra"     => ["id" => "form_builder"],
    "url"       => "builder/builderform/build_form",
    "data"      => '$(this).serialize()+"&"+$(".data-form").find("select, textarea, input").serialize()',
    "onSuccess" => 'function(data) {
                if (data.message == "ok") {
                    Swal.fire("Builder Successfully!", "", "success");
                    $(".respondse").html(data.resp.url);
                }else{
                    Swal.fire("FAIL!", data.messages.error, "error");
                }
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
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>NAME</th>
            <th>TYPE DATA</th>
            <th>PRIMARY</th>
            <th>TYPE FORM</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $row = "";
        foreach ($fieldTable as $key => $value) {
            $row .= "
                <tr>
                    <td>" . ($key + 1) . "</td>
                    <td>$value->name</td>
                    <td>$value->type</td>
                    <td>$value->primary_key</td>
                    <td>
                        " . $form->dropdown([
                "id"    => $value->name,
                "data"  => get_type_form()
            ]) . "
                    </td>
                </tr>";
        }
        echo $row;
        ?>
    </tbody>
</table>

<?= $form->endForm() ?>