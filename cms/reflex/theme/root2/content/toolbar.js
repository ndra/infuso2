$(function() {

    mod.on("reflex/beforeLoad",function(p) {    
        p.viewMode = $(".qoi8w451jl select[name='viewMode']").val();
    });
    
    $(".qoi8w451jl .create").click(function() {
        var container = $(this).parents(".qoi8w451jl");
        var collection = container.attr("infuso:collection");
        mod.call({
            cmd:"infuso/cms/reflex/controller/create",
            collection:collection
        },function(url) {
            window.location.href = url;
        });
    });

});