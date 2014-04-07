jQuery.fn.list = function(param) {

    var e = $(this);
        
    if(param === undefined) {
        
        $(this).find(".list-item").mousedown(function() {
            $(this).toggleClass("selected");
        });
       
        return e;
    }
    
    if(param === "selection") {
        var ret = [];
        e.find(".list-item.selected").each(function() {
            ret.push($(this).attr("data:id"));
        });
        return ret;
    }
    
    if(param === "keep-selection") {
        var sel = e.mod().list("selection");
        e.data("lsit-selection",sel);
        return e;
    }
    
    if(param === "restore-selection") {
        var sel = e.data("lsit-selection");
        e.find(".list-item").each(function() {
            if($.inArray($(this).attr("data:id",sel))) {
                $(this).addClass("selected");
            }
        });
        return e;
    }  

}