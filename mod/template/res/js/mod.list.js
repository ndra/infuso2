/**
 * Плагин для работы со списками
 * - Позволяет выделят один или несколько элементов списка.
 * - Получаеть массив id выделенных элементов
 **/
jQuery.fn.list = function(param, param2) {

    // Контейнер
    var $e = $(this);
    var $list = $(this);

    var triggerSelectionEvent = function() {
        $e.trigger({
            type: "list/select",
		    selection: $e.list("selection")
		});
    }
    
    var listItem = function($e) {
        $e = $($e);
        while($e.length) {
            if($e.hasClass("list-item")) {
                return $e;
            }
            $e = $e.parent();
        }
        return $("xxx");
    } 
    
    var selectHandle = function($e) {
        $e = $($e);
        while($e.length) {
            if($e.filter(param.selectHandle).length) {
                return $e;
            }
            $e = $e.parent();
        }
        return $("xxx");
    } 

    /**
     * Создаем список
     **/
    if(param === undefined || typeof(param) === "object" ) {

    
        var defaultParams = {
            selectHandle: ".list-item"
        };
        param = $.extend({},defaultParams,param)

        // Сохраняет состояние выделения
        var keepSelection = function() {
            var sel = $e.list("selection");
            jQuery.fn.list.keepSelection[param.keepSelection] = sel;
        }

        // Восстанавливает состояние выделения
		var restoreSelection = function() {
			var sel = jQuery.fn.list.keepSelection[param.keepSelection];
            if(!sel) {
                return;
            }
	        $e.find(".list-item").each(function() {
	            if($.inArray($(this).attr("data:id"),sel) !== -1) {
	                $(this).addClass("selected");
	            }
	        });

            if(sel.length != $e.list("selection").length) {
                triggerSelectionEvent();
            }
        }

        $list.mousedown(function(event) {
            var $handle = selectHandle(event.target);            
            $item = listItem($handle);
            if($item.length && !event.ctrlKey && !param.easyMultiselect) {
                $list.find(".list-item.selected").removeClass("selected");  
            }
            $item.toggleClass("selected");
            keepSelection();
            triggerSelectionEvent();
        });

        // Добавляем контейнеру табиндекс чтобы он мог реагировать на нажатие
        $e.attr("tabindex", 1);

        // Обрабатываем горячие клавиши - вверх и вниз
        $e.keydown(function(event) {
            if(event.which == 38) {
                $(this).list("prev");
            }
        });

        restoreSelection();

        return $e;
    }

    if(param === "selection") {
        var ret = [];
        $e.find(".list-item.selected").each(function() {
            ret.push($(this).attr("data:id"));
        });
        return ret;
    }
    
    if(param === "deselect") {
        $e.find(".list-item").removeClass("selected");
        triggerSelectionEvent();
    }
    
    if(param === "deselect") {
        $e.find(".list-item").removeClass("selected");
        triggerSelectionEvent();
    }
    
    // Выделяет элементы
    if(param === "select") {        
        var selection = param2;
        if(typeof selection != "array") {
            selection = [selection];
        }
        $e.find(".list-item").each(function() {
            if($.inArray($(this).attr("data:id"), selection) != -1) {
                $(this).addClass("selected");            
            } else {
                $(this).removeClass("selected");
            }
        });
        triggerSelectionEvent();
    }
    
    if(param === "next") {
        var selection = $list.list("selection");
        if(!selection.length) {
            $e.list("selectFirst");
        } else {
            var next = $e.find(".list-item.selected:last").next(".list-item").attr("data:id");
            if(next === undefined) {
                next = $e.find(".list-item:last").attr("data:id");
            }
            $e.list("select", next); 
        }        
    }

    if(param === "prev") {
        mod.msg("prev");
    }
    
    if(param=="selectFirst") {
        var id = $e.find(".list-item:first").attr("data:id");
        $e.list("select", id);
    }

}

jQuery.fn.list.keepSelection = {};
