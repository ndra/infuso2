$(function() {

    $(".eud8rxwk3d").submit(function(e) {  
        e.preventDefault();
        var data = $(this).mod("formData");
        mod.call({
            cmd:"infuso/board/controller/projects/save",
            projectId: $(this).attr("data:project"),
            data:data
        });
    });

});