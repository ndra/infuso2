$(function() {

    $(".vgd2nzxvnn").mod().init(function() {
        var container = $(this);
        var checkbox = container.find("input[type='checkbox']");
        checkbox.change(function() {
            var val = checkbox.prop("checked");
            container.find("input[type='hidden']").val(val ? 1 : 0);
        });
    });

});