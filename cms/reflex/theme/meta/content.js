mod.init(".r410k2bcoa", function() {

    var container = $(this);
    
    var load = function() {    
        mod.call({
            cmd: "infuso/cms/reflex/controller/meta/getMeta",
            index: container.attr("data:index")
        }, function(html) {
            container.html(html);
        });    
    };
    
    container.on("reflex/updateMeta", load);
    load();

});