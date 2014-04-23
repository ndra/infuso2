$(function() {

    mod.on("beforeLoadCollection", function(filter) {
        filter.search = $(".swjdscw1a3 .quicksearch").val();
        filter.page = $(".swjdscw1a3 input[name=pager]").val();
        filter.user = $(".swjdscw1a3 select[name=user]").val();
        filter.status = $(".swjdscw1a3 select[name=status]").val();
    });

    $(".swjdscw1a3 .quicksearch").on("input", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3 .pager").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3 .user").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3 .status").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".swjdscw1a3").on("collection-loaded", function(e,data) {
        $(".swjdscw1a3").pager("total", data.total);
    });

});