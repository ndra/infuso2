mod.init(".hSPlyiV6sp", function() {

    var $container = $(this);
    
    $container.find("span").click(function() {
    
        $(this).trigger({
            type: "board/openGroup",
            groupId: $(this).attr("data:group")
        });   
            
    });

});