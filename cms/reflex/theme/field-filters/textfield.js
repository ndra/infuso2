mod(".l2bfEewpo6").init(function() {
    
    alert(12);

    var $container = $(this);
    
    var $select = $container.find("select");
    var $input = $container.find(".input");
    var $hidden = $container.find("input[type='idden']");
    
     mod.msg(121212);
    
    var updateData = function() {
       
        mod.msg($select.val());
        switch($select.val()) {
            case "eq":
            case "like":
                $input.show();
                break;
            case "void":
            case "non-void":
                $input.hide();
                break;
        }
        $hidden.val($input.val()).attr("name", );
    };
    
    updateData();
    
    $select.on("change", updateData);
    $input.on("change", updateData);
    $input.on("input", updateData);
    
});