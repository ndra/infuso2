/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */

jQuery(function($) {
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
        'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
        'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Нед',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['ru']);
});
    
mod.init(".datetime-hZ1EqT1dlO", function() {

    var $container = $(this);
    var $input = $(this).find(".visibleField");
    var $inputTime = $(this).find(".timeField");
    var $inputHidden = $(this).find(".hiddenField");
    
    var dateToText = function(date) {
        var d = date.getFullYear();
        d += "-" +  ('0' + (date.getMonth() + 1)).slice(-2);
        d += "-" +  ('0' + (date.getDate())).slice(-2);
        if($inputTime.length) {
            d += " ";
            d += ('0' + (date.getHours())).slice(-2);
            d += ":" + ('0' + (date.getMinutes())).slice(-2);
            d += ":" + ('0' + (date.getSeconds())).slice(-2);
        }
        return d;
    }
    
    var textToDate = function(text) {
        var r = text.match(/^(\d+)-(\d+)-(\d+)(\s(\d+):(\d+):(\d+))?/);
        if(r) {
            if(r[4] !== undefined) {
                var d = new Date(r[1],r[2] * 1 - 1,r[3],r[5],r[6],r[7]);
            } else {
                var d = new Date(r[1],r[2] * 1 - 1,r[3]);
            }
            return d;
        } else {
            return null;
        }
    }
    
    var fireChangedEvent = function() {
        $inputHidden.trigger({
            type: "datechange",
            value: $inputHidden.val(),
            date: textToDate($inputHidden.val()) // Объект Date
        });
    }
    
    // Обновляет видимое значение на основании скрытого поля
    var updateDatepickerValue = function() {
        
        var date = textToDate($inputHidden.val());
        $input.datepicker("setDate", date);
        
        if(date) {
            var time = "";
            time += ('0' + date.getHours()).slice(-2);
            time += ":";
            time += ('0' + date.getMinutes()).slice(-2);
            $inputTime.val(time);
        } else {
            $inputTime.val("");
        }
        
        // Чтобы не выбрасывалocь mod/monitor
        mod.monitorReset($input, "value");
        if($inputTime.length) {
            // Чтобы не выбрасывалocь mod/monitor
            mod.monitorReset($inputTime, "value");
        }
        
    }
    
    // Обновляет скрытые поля при изменении видимого поля
    var updateHiddenFields = function() {
        var date = $input.datepicker("getDate");
        if(date) {
            if($inputTime.length) {
                var time = $inputTime.val().match(/(\d+)\s*[:\.\-]\s*(\d+)/);
                if(time) {
                    date.setHours(time[1]);
                    date.setMinutes(time[2]);
                } else {
                    date.setHours(0);                
                    date.setSeconds(0);     
                }
            }
            var d = dateToText(date);
            $inputHidden.val(d);
            // Чтобы не выбрасывалocь mod/monitor
            mod.monitorReset($inputHidden, "value");
        } else {
            $inputHidden.val("");
            // Чтобы не выбрасывалocь mod/monitor
            mod.monitorReset($inputHidden, "value");
        }
    }
    
    mod.monitor($input, "value");
    mod.monitor($inputTime, "value");
    mod.monitor($inputHidden, "value");
    
    var handleVisibleChanged = function() {
        updateHiddenFields();
        fireChangedEvent();
    } 
    
    $input
        .on("mod/monitor", handleVisibleChanged);
    $inputTime
        .on("mod/monitor", handleVisibleChanged);
        
    // При изменении скрытого поля обновляем видимые 
    // и выбрасываем событие изменения
    $inputHidden.on("mod/monitor", function() {
        updateDatepickerValue();
        fireChangedEvent();
    })
    
    // Создаем дейтпикер
    $input.datepicker({
        yearRange: "c-5:c+5",
        changeMonth: true,
        changeYear: true,
        onSelect: updateHiddenFields,
        beforeShow:function() {
            var options = {};
            $inputHidden.trigger({
                options: options,
                type :"datepicker"
            });
            return options;
        }
    });
    
    updateDatepickerValue();
    
});