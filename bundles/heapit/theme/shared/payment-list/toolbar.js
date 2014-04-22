$(function() {

    mod.on("beforeLoadCollection", function(filter) {
        filter.search = $(".payment-toolabr-ah3hf8pqdk .quicksearch").val();
        filter.page = $(".payment-toolabr-ah3hf8pqdk input[name=pager]").val();
    });

    $(".payment-toolabr-ah3hf8pqdk .quicksearch").on("input", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk .pager").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk").on("collection-loaded", function(e,data) {
        $(".payment-toolabr-ah3hf8pqdk").pager("total", data.total);
    });

});