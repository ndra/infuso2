mod.init(".x15OtxtOxFL", function() {
    
    var $container = $(this);
    var $hidden = $container.find("input[type=hidden]");

    var updateValue = function() {
        var values = [];
        $container.find("input[type=checkbox]:checked").each(function() {
            values.push($(this).attr("data:key"));
        });
        $hidden.val(values.join(" "));
    };
    
    $container.find("input[type=checkbox]").click(updateValue);
    
});