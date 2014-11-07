mod.init(".x55qv4lhb8m", function() {
    
    var $container = $(this);
    
    $container.find(".task-list").click(function(event) {
        if(this.href == window.location.href) {
            event.preventDefault();
        }
        mod.msg(12);
    });
    
})