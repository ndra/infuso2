$(function() {
    var form = $(".m69716bx32");     
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
}    