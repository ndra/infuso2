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
    
    $(".datepicker-89z0fcfy09").mod("init", function() {
    
        var lastValue = null;
        
        var fireChangeEvent = function() {
            if(lastValue != inputHidden.val()) {
                inputHidden.trigger("change");
            }            
            lastValue = inputHidden.val();
        }
    
        var input = $(this).find(".visibleField");
        var inputHidden = $(this).find(".hiddenField");
        
        input.on("input", fireChangeEvent);
        
        input.datepicker({
            yearRange: "c-5:c+5",
            changeMonth: true,
            changeYear: true,
            altField: inputHidden,
            altFormat: "yy-mm-dd",
            onSelect: fireChangeEvent
        });
        
        var button = $(this).find(".button");
        button.click(function(){
            input.val('');
            inputHidden.val('');    
            fireChangeEvent();
        });
        
        input.on("input", function(){
            if (!$(this).val()) {
                inputHidden.val('');
                fireChangeEvent();
            }
        });
        
        var fastDate = $(this).find(".fast-date");
        fastDate.click(function(){
            var val = $(this).find(".fast-date-val").val();
            input.datepicker( "setDate", val );      
        });
    });

});