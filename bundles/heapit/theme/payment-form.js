$(function() {
    var form = $(".payment-vlj855earc");     
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
});       