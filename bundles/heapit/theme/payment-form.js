$(function() {

    var form = $(".payment-vlj855earc");     
    $(document).on('keydown', function(event) {
        if (event.ctrlKey || event.metaKey) {
            switch (String.fromCharCode(event.which).toLowerCase()) {
                case 's':
                    event.preventDefault();
                    form.parent().submit();
                    break;
            }
        }
    });
    
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