$(function() {

    $(".comments-nni5vez0qz").mod("init", function() {
        $(this).find(".item").click(function() {
            $.window({
                call: {
                    cmd: "infuso/heapit/controller/comments/get",
                    id: $(this).attr("data:id")
                }
            });
        });
    });

});