$(function() {

    mod.msg("ololo");
    
    $(".x2s6mdnq7sy").on("listSelectionChanged",function(e,params) {
        $(this).find(".c-toolbar").trigger("selectionChanged",[params.selection]);
    })

});