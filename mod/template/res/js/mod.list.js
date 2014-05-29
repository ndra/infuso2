/**
 * Плагин для работы со списками
 * - Позволяет выделят один или несколько элементов списка.
 * - Получаеть массив id выделенных элементов
 **/
jQuery.fn.list = function(param) {

    // Контейнер
    var $e = $(this);

    var triggerSelectionEvent = function() {
        $e.trigger({
            type: "list/select",
		    selection: $e.list("selection")
		});
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

        // Обрабатываем клик на элементе - выделение
        $e.find(".list-item").mousedown(function(event) {

            var item = $(this);

            if(!param.selectHandle || $(event.target).is(item.find(param.selectHandle))) {
                if(!event.ctrlKey && !param.easyMultiselect) {
                    $e.find(".list-item.selected").removeClass("selected");
                }
                item.toggleClass("selected");
    			keepSelection();
                triggerSelectionEvent();
            }
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

    if(param === "prev") {
        mod.msg("prev");
    }

}

jQuery.fn.list.keepSelection = {};
