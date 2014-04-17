$(function(){
    var input = $("input[name='occId']").parent().find("input[type='text']");
    $( input ).on( "autocompletechange", function( event, ui ) {console.log(1);} );    
});