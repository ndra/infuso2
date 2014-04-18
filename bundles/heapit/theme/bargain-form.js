$(function() {
    var form = $(".qs1t5z7t8d");     
    $(window).bind('keydown', function(event) {
        if (event.ctrlKey || event.metaKey) {
            switch (String.fromCharCode(event.which).toLowerCase()) {
            case 's':
                event.preventDefault();
                    form.parent().submit();
                break;
            }
        }
    });
    
    var form = $(".qs1t5z7t8d");

    // Показываем/прячем поле с причиной отказа

    var updateRefusalDescription = function() {
    
        var row = form.find(".refusalDescription");
        var select = form.find("select[name='status']");
        
        if(select.val() == 400) {
            row.show();    
        } else {
            row.hide();
        }
    }
    
    updateRefusalDescription();
    
    form.find("select[name='status']").change(updateRefusalDescription);
    
});