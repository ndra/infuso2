jQuery.fn.list = function(param) {

    var e = $(this);
    
    /**
     * Создаем список
     **/
    if(param === undefined || typeof(param) === "object" ) {
    
        if(!param) {
            param = {};
        }
        
        var e = $(this);
        
        var keepSelection = function() {
            var sel = e.list("selection");
            jQuery.fn.list.keepSelection[param.keepSelection] = sel;
        }
        
		var restoreSelection = function() {
			var sel = jQuery.fn.list.keepSelection[param.keepSelection];
	        e.find(".list-item").each(function() {
	            if($.inArray($(this).attr("data:id"),sel) !== -1) {
	                $(this).addClass("selected");
	            }
	        });
        }

        $(this).find(".list-item").mousedown(function() {
            $(this).toggleClass("selected");
			keepSelection();
			e.trigger("listSelectionChanged",[{
			    selection: e.list("selection")
			}]);
        });
        
        restoreSelection();

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

jQuery.fn.list.keepSelection = {};
