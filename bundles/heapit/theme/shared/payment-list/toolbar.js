$(function() {

    mod.on("beforeLoadCollection", function(filter) {
        filter.search = $(".payment-toolabr-ah3hf8pqdk .quicksearch").val();
        filter.page = $(".payment-toolabr-ah3hf8pqdk input[name=pager]").val();
        filter.from = $(".payment-toolabr-ah3hf8pqdk input[name=from]").val();
        filter.to = $(".payment-toolabr-ah3hf8pqdk input[name=to]").val();
        filter.statuses = $(".payment-toolabr-ah3hf8pqdk input[type=checkbox]:checked").map(function(_, el) { return $(el).val() }).get();
    });

    $(".payment-toolabr-ah3hf8pqdk .quicksearch").on("input", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk .pager").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk input[type=checkbox]").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk input[name=from]").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk input[name=to]").on("change", function() {
        mod.fire("collectionFilterChanged");
    });
    
    $(".payment-toolabr-ah3hf8pqdk").on("collection-loaded", function(e,data) {
        $(".payment-toolabr-ah3hf8pqdk").pager("total", data.total);
    });

});