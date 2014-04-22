$(function() {

    mod.on("beforeLoadComments", function(filter) {
        filter.search = $(".comments-toolbar-9mblmj0kwq .quicksearch").val();
        filter.page = $(".comments-toolbar-9mblmj0kwq input[name=pager]").val();
    });

    $(".comments-toolbar-9mblmj0kwq .quicksearch").on("input", function() {
        mod.fire("commentsFilterChanged");
    });
    
    $(".comments-toolbar-9mblmj0kwq .pager").on("change", function() {
        mod.fire("commentsFilterChanged");
    });
    
    $(".comments-toolbar-9mblmj0kwq").on("collection-loaded", function(e,data) {
        $(".comments-toolbar-9mblmj0kwq").pager("total", data.total);
    });

});