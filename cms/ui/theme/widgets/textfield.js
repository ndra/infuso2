$(function() {

    $(".x8zq1fi07zr").mod("init", function() {
        var button = $(this).find(".button");
        button.click(function() {
            $(this).parent().find("input").val("").trigger("input");
        });
    });

});