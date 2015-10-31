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
        d += " ";
        d += ('0' + (date.getHours())).slice(-2);
        d += ":" + ('0' + (date.getMinutes())).slice(-2);
        d += ":" + ('0' + (date.getSeconds())).slice(-2);
        return d;
    }
    
    var textToDate = function(text) {
        var r = text.match(/^(\d+)-(\d+)-(\d+)(\s(\d+):(\d+):(\d+))?/);
        return new Date(r[1],r[2] * 1 - 1,r[3],r[5],r[6],r[7]);
    }
    
    var updateDatepickerValue = function() {
        var date = textToDate($inputHidden.val());
        $input.datepicker("setDate", date);
        var time = "";
        time += ('0' + date.getHours()).slice(-2);
        time += ":";
        time += ('0' + date.getMinutes()).slice(-2);
        $inputTime.val(time);
    }
    
    // Создаем дейтпикер
    $input.datepicker({
        yearRange: "c-5:c+5",
        changeMonth: true,
        changeYear: true
    });
    
    updateDatepickerValue();
    
    // Мониторим изменения тектового поля
    
    var updateHiddenFields = function() {
        var date = $input.datepicker("getDate");
        var time = $inputTime.val().split(":");
        date.setHours(time[0] || 0);
        date.setMinutes(time[1] || 0);
        var d = dateToText(date);
        $inputHidden.val(d);
    }
    
    mod.monitor($input, "value");
    mod.monitor($inputTime, "value");
    $input.on("mod/monitor", updateHiddenFields);
    $inputTime.on("mod/monitor", updateHiddenFields);
    
    var handleBlur = function() {
        updateHiddenFields();
        updateDatepickerValue();
    }
    $input.blur(handleBlur);
    $inputTime.blur(handleBlur);
    
});