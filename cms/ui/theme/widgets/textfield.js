mod.init(".x8zq1fi07zr", function() {

    var $input = $(this).find("input");

    var $button = $(this).find(".button");
    
    $(this).on("input", function() {
        updateButtonVisibility();
    });
    
    var updateButtonVisibility = function() {
        if($input.val()) {
            $button.show();
        } else {
            $button.hide();
        }
    }
    
    $button.click(function() {
        $(this).parent().find("input").val("").trigger("input");
    });

});