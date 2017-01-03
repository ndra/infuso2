mod(".payment-vlj855earc").init(function() {
    
    var $container = $(this);
    
    // Сохранение по ctrl + s
    $(document).on('keydown', function(event) {
        if (event.ctrlKey || event.metaKey) {
            switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    $container.parent().submit();
                    break;
            }
        }
    });
    
    var $date = $container.find("input[name=date]");
    $date.on("datechange", function() {
        $container.find(".c-similar-payments").triggerHandler("refresh");
    });
    
    // @todo рефакторить это
    $(".payment-vlj855earc input[name=direction]").change(function() {
        var value = $("input[name=direction]:checked").val();
        if(value == "income") {
            $(".payment-vlj855earc .group-income").removeAttr("disabled");
            $(".payment-vlj855earc .group-expenditure").attr("disabled", true);
        } else {
            $(".payment-vlj855earc .group-expenditure").removeAttr("disabled");
            $(".payment-vlj855earc .group-income").attr("disabled", true);
        }
    });
    
});       