$(function() {

    mod.on("beforeLoadOrgs", function(filter) {
        filter.search = $(".x13g6lu6fbo .quicksearch").val();
    });

    $(".x13g6lu6fbo .quicksearch").on("input",function() {
        mod.fire("orgFilterChanged");
    });

});