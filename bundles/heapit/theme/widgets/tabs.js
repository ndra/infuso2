mod(".x8dhiuue82x").init(function() {
    
    var container = $(this);

    var open = function(n) {
        container.find("> .head > span").removeClass("active");
        container.find("> .head > span").eq(n).addClass("active");
        container.find("> .content > .tab").hide();
        container.find("> .content > .tab").eq(n).show();
    }

    $(this).find(".head span").each(function(n) {
        $(this).click(function() {
            open(n);
        });        
    })
});