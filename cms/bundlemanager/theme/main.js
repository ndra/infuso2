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
    $(window).resize(updateHeight);
    
    // Управление табами

    var $tabsHead = $(".zdh71269gn").find(".main > .tabs > .tabs-head");
    var $tabsContainer = $(".zdh71269gn").find(".main > .tabs > .tabs-container");
    
    // Генерирует случайно id из 10 символов
    
    var makeid = function() {
    
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    
        for( var i=0; i < 10; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
    
        return text;
    }
    
    // Добавляет табу
    
    var addTab = function(params) {
    
        if(!params.id) {
            params.id = makeid();
        }
        
        var $tab = $tabsHead.children().filter(function() {
            return $(this).data("tab-id") == params.id;
        });
        
        if($tab.length == 0) {
        
            var $tab = $("<div>")
                .html(params.title)
                .data("tab-id", params.id)
                .appendTo($tabsHead)
                .click(function() {
                    selectTab($tab);
                });
                
            var $content = $("<div>")
                .css({height:"100%"})
                .data("tab-id", params.id)
                .appendTo($tabsContainer);            
                
            mod.call(params.loader, function(html) {
                $content.html(html);
            });
        
        }
        
        new Sortable($tabsHead.get(0)); 
        
        selectTab($tab);
    }
    
    // Активирует табу
    
    var selectTab = function($tab) {
    
        var id = $tab.data("tab-id");
        
        // Подсвечиваем активную табу
        $tabsHead.children().each(function() {
            var $e = $(this);
            if($e.data("tab-id") == id) {
                $e.addClass("active");
            } else {
                $e.removeClass("active");
            }
        })
        
        // Показываем ее контент
        $tabsContainer.children().each(function() {
            var $e = $(this);
            if($e.data("tab-id") == id) {
                $e.show();
            } else {
                $e.hide();
            }
        });
        
        $(".zdh71269gn").layout("update");
        
    }
   
    $(".zdh71269gn").on("bundlemanager/openFile", function(event) {                
        addTab({
            title: event.path,
            id: "file:"+event.path,
            loader: {
                cmd: "infuso/cms/bundlemanager/controller/files/editor",
                path: event.path
            }
        });        
    });
    
    $(".zdh71269gn").on("bundlemanager/openTemplate", function(event) {                
        addTab({
            title: event.theme+":"+event.template,
            id: "template:"+event.theme+":"+event.template,
            loader: {
                cmd: "infuso/cms/bundlemanager/controller/theme/editor",
                theme: event.theme,
                template: event.template,
            }
        });        
    });

});