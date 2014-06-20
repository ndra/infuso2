mod.init(".pn2dSKDht6", function() {
    $(this).find(".view").click(function() {
        window.open($(this).attr("data:url"));
    });
});