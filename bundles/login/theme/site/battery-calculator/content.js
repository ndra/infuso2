mod.init(".x0zD0C7SrZE", function() {

    var $container = $(this);
    
    function isNormalInteger(str) {
        var n = ~~Number(str);
        return String(n) === str && n > 0;
    }
    
    // Загружает данные
    var load = function() {
        
        var data = {};
        $container.find(".c-toolbar").trigger({
            type: "beforeLoad",
            toolbar: data
        });
        
        if(data.cell && isNormalInteger(data.serial) && isNormalInteger(data.parallel)) {
            var url = "/battery/" + data.cell + "-" + data.serial + "s-" + data.parallel + "p";
            
            var query = [];
            if(data.bms != 0) {
                query.push("bms=" + data.bms);
            }
            if(data.charger != 0) {
                query.push("charger=" + data.charger);
            }
            if(data.work != true) {
                query.push("work=" + data.work);
            }
            query = query.join("&");
            if(query) {
                url += "?" + query;    
            }
            
            history.pushState(null, null, url);
        }
        
        $container.find(".preloader").show();
        
        mod.call({
            cmd: "infuso/site/controller/batterycalculator/result",
            data: data
        }, function(data) {
            $container.find(".ajax-container-top").html(data.top);
            $container.find(".ajax-container-bottom").html(data.bottom);
            $container.find(".ajax-container-heading").html(data.heading);
            $container.find(".preloader").hide();
        }, {
            unique: "WGnF6tAMa8"
        });
    }
    
    $container.on("toolbarChanged", load);

});