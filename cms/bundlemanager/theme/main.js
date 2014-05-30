$(function() {

    var updateHeight = function() {
    
        var y = $(".zdh71269gn").offset().top;
        var h = window.document.body.clientHeight - y;
        $(".zdh71269gn").css({
            height: h
        });
        
        $(".zdh71269gn").layout("update");
    
    }
    
    $(".zdh71269gn").layout();
    $(".zdh71269gn .tabs").layout();
    
    updateHeight();
    setInterval(updateHeight,1000);
    
    // Управление табами

    var $tabsHead = $(".zdh71269gn").find(".main > .tabs > .tabs-head");
    var $tabsContainer = $(".zdh71269gn").find(".main > .tabs > .tabs-container");
    
    var addTab = function(params) {
        var $tab = $("<div>").html(params.title).appendTo($tabsHead);
        var $content = $("<div>").css({height:"100%"}).html(params.title).appendTo($tabsContainer);
        mod.call(params.loader, function(html) {
            $content.html(html);
        });
    }
    
    $(".zdh71269gn").on("bundlemanager/openFile", function(event) {
                
        addTab({
            title: event.path,
            loader: {
                cmd: "infuso/cms/bundlemanager/controller/files/editor",
                path: event.path
            }
        });
        
    });

});