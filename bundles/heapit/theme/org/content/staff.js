$(function() {
    var staffTable = $(".staff-x1lsfa0a64l .list");
    $(".staff-x1lsfa0a64l .controls .add").click(function(e) {        
        ///e.preventDefault();
        mod.call({
            cmd:"infuso/heapit/controller/occupation/addNew",
            orgId: $(this).attr("data:orgid"),
        }, function(ret){
            $(ret).appendTo(staffTable);       
        });
    });

});