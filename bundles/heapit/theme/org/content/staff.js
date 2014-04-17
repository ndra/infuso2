$(function() {
    var staffTable = $(".staff-x1lsfa0a64l .list");
    $(".staff-x1lsfa0a64l .controls .add").click(function(e) {        
        e.preventDefault();
        mod.call({
            cmd: "infuso/heapit/controller/occupation/addNew",
            orgId: $(this).attr("data:orgid"),
        }, function(ret){
            $(ret).appendTo(staffTable);       
        });
    });
    
    
    $(document).on("click", ".staff-x1lsfa0a64l .list .delete", function(event){
        event.preventDefault();
        var that = this;
        if (confirm("Точно удалить?")) {
            mod.call({
                cmd: "infuso/heapit/controller/occupation/delete",
                occId: $(this).attr("data:occId")
            }, function(ret){
                if(ret){
                    $(that).parent().parent().remove();
                }
            });
        }       
    });

});