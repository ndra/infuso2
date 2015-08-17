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

    var lastValue = null;
    
    var fireChangeEvent = function(date) {
        var dateTime = $inputHiddenDate.val() + " " + $inputHiddenTime.val();
        $inputHidden.val(dateTime);
        $input.val(date + " " + $inputHiddenTime.val());
        if(lastValue != $inputHidden.val()) {
            $inputHidden.trigger("change");
        }            
        lastValue = $inputHidden.val();
    }
    
    var checkTime = function(timeStr) {
        var timePieces = timeStr.split(":");

        if(timePieces.length != 3){
            return false;
        }
        
        if(/\./.test(timePieces[0]) || timePieces[0]*1 < 0 || timePieces[0]*1 > 24){
            return false;
        }
        
        if(/\./.test(timePieces[1]) || timePieces[1]*1 < 0 || timePieces[1]*1 > 60){
            return false;
        }
        
        if(/\./.test(timePieces[2]) || timePieces[2]*1 < 0 || timePieces[2]*1 > 60){
            return false;
        }
        
        return true;
    }
        
    var $container = $(this);
    var $input = $(this).find(".visibleField");
    var $inputHidden = $(this).find(".hiddenField");
    var $inputHiddenDate = $(this).find(".hiddenFieldDate");
    var $inputHiddenTime = $(this).find(".hiddenFieldTime");
    var lastTime = $inputHiddenTime.val();
    // Создаем дейтпикер
    $input.datepicker({
        yearRange: "c-5:c+5",
        changeMonth: true,
        changeYear: true,
        altField: $inputHiddenDate,
        altFormat: "yy-mm-dd",
        onSelect: fireChangeEvent
    });
    
    
    $input.on("input", function() {
        if (!$(this).val()) {
            $inputHidden.val('');
        }else{
            var datetime = $(this).val().split(" ");
            var date = datetime[0];
            var time = datetime[1];
            
            if(!time || !checkTime(time)){
                time = lastTime;
            }
            
            $inputHiddenTime.val(time);
            lastTime = time;
        }
        fireChangeEvent(date);
    });
    
    
    /*$container.on("setDate",function(event) {
        var date = new Date(event.date * 1000);
        $input.datepicker("setDate", date);
    })*/
    
});