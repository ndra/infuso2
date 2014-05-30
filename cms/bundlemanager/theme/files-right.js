$(function() {

    var createList = function() {
        $(".i00sceaxx3").list({
           // selectHandle: ".name"
        });
    }
    
    $(".i00sceaxx3").on("updateList", function() {
        createList();    
    });
    
    createList();
    
});