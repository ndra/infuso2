mod(".l2bfEewpo6").init(function() {
    
    var $container = $(this);
    
    var $select = $container.find("select");
    var $input = $container.find(".input");
    var $hidden = $container.find("input[type='hidden']");
    
    var updateData = function() {
        
        var data = null;
        var val = $input.val().trim();
       
        switch($select.val()) {
            case "like":
            case "eq":
                data = val ? {filter: $select.val(), value: val} : null;
                $input.show();
                break;
            case "void":
            case "non-void":
                data = {filter: $select.val()};
                $input.hide();
                break;
        }
        
        data = data ? JSON.stringify(data) : "";
        $hidden.val(data);
    };
    
    updateData();
    
    $select.on("change", updateData);
    $input.on("change", updateData);
    $input.on("input", updateData);
    
});