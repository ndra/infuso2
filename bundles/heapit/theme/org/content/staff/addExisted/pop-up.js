mod(".popup-ejmhyas19m").init(function() {
     var addButton = $(this).find(".addItem-li16br8ida");
     var closeButton = $(this).find(".close-li16br8ida");
     var occIdInput = $(this).find("input[name='occId']");
     var staffTable = $(".staff-x1lsfa0a64l .list");
     
     addButton.click(function(event){
         event.preventDefault(); 
         var that = this;
         mod.call({
             cmd: "infuso/heapit/controller/occupation/addExisted",
             orgId: $(this).attr("data:orgid"),
             occId: occIdInput.val()
         }, function(ret){
             $(ret).appendTo(staffTable); 
             occIdInput.parent().find("input[type='text']").val(""); //очищаем селект
             $(that).parent().hide();    
         });  
     });   
    
     closeButton.click(function(event){
         event.preventDefault();
         $(this).parent().hide();
     });   
 });