$(function() {

    mod.on("beforeLoadCollection", function(filter) {
        filter.search = $(".swjdscw1a3 .quicksearch").val();
        filter.page = $(".swjdscw1a3 input[name=pager]").val();
    });

    $(".swjdscw1a3 .quicksearch").on("input", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3 .pager").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3").on("collection-loaded", function(e,data) {
        $(".swjdscw1a3").pager("total", data.total);
    });

});