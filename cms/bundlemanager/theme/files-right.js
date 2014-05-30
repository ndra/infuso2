$(function() {

    var createList = function() {
        $(".i00sceaxx3").list();
    }
    
    $(".i00sceaxx3").on("updateList", function() {
        createList();    
    });
    
    createList();
    
});