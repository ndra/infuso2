$(function() {

    mod.on("beforeLoadOrgs", function(filter) {
        filter.search = $(".x13g6lu6fbo .quicksearch").val();
        filter.page = $(".x13g6lu6fbo input[name=pager]").val();
    });

    $(".x13g6lu6fbo .quicksearch").on("input", function() {
        mod.fire("orgFilterChanged");
    });
    
    $(".x13g6lu6fbo .pager").on("change", function() {
        mod.fire("orgFilterChanged");
    });
    
    $(".x13g6lu6fbo").on("collection-loaded", function(e,data) {
        $(".x13g6lu6fbo").pager("total", data.count);
    });

});