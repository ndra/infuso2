/**
 * Плагин для работы со списками
 * - Позволяет выделят один или несколько элементов списка.
 * - ПОлучаеть массив id выделенных элементов
 * -
 **/
jQuery.fn.list = function(param) {

    // Контейнер
    var $e = $(this);

    var triggerSelectionEvent = function() {
        $e.trigger("list/select",[{
		    selection: $e.list("selection")
		}]);
    }

    /**
     * Создаем список
     **/
    if(param === undefined || typeof(param) === "object" ) {

        if(!param) {
            param = {};
        }

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

        $e.find(".list-item").mousedown(function(event) {
            if(!event.ctrlKey) {
                $e.find(".list-item.selected").removeClass("selected");
            }
            $(this).toggleClass("selected");
			keepSelection();
            triggerSelectionEvent();
        });

        $e.attr("tabindex", 1);
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

    if(param === "prev") {
        mod.msg("prev");
    }

}

jQuery.fn.list.keepSelection = {};
