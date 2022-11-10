$(function() {
    $("body").on("click",".add-form",function(){
        $("#"+$(this).attr("data-target")+"").empty();
        $("#"+$(this).attr("data-target")+"").show('slow');
        if ($(this).attr("data-url")) {
            $("#"+$(this).attr("data-target")+"").load($(this).attr("data-url"));
        }
        $("#"+$(this).attr("data-close")+"").hide();
    });

    //default hidden
    $(".form-data").hide();

    $("body").on("click",".cancel-form",function(){
        $("#"+$(this).attr("data-target")+"").show('slow');
        $("#"+$(this).attr("data-close")+"").empty();
        $("#"+$(this).attr("data-close")+"").hide();
    });
})