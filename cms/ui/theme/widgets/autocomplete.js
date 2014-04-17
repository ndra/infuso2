$(function(){
    $(".autocomplete-jk7zsaj00t").mod("init", function(){
        var input = $(this).find("input[type='text']");
        var hiddenInput = $(this).find("input[type='hidden']");
        var button = $(this).find("div"); 
        var sourceUrl = input.attr("widget:cmd");
        var sourceParams = input.attr("widget:cmdparams").split(";");
        
        input.autocomplete({
            delay: 500,
            minLength: 0,
            source: function(request, response) {
                
                //в request.term лежит то что юзер ввел в поле поиска
                var cmdObject = {cmd: sourceUrl , query: request.term};
                //разбираем параметры для контроллера 
                if(sourceParams){
                    $.each(sourceParams, function (key, val){
                        var param = val.split(":");
                        if(param[0] && param[1]){
                            cmdObject[param[0]] = param[1];     
                        }           
                    });             
                }
                mod.call(cmdObject, function(data){
                    //мапим данные ответа
                    var reponseData = $.map(data.suggestions, function(m) {
                        return {
                            label: m.value,
                            key: m.key,
                            icon: m.icon
                        };
                    });
                    
                    //ф-ция reponse принимае массив  опциии 
                    response(reponseData);    
                });    
            },
            select: function( event, ui ) { hiddenInput.val(ui.item.key); }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            var str = "";
            if(item.icon){
                str = "<a>" + "<img src='" + item.icon + "'/>" + item.label + "</a>";
            }else{
                str = "<a>" + item.label + "</a>";    
            }
            return $( "<li>" )
                .append( str )
                .appendTo( ul );
            };
        
        input.click(function(){
            $(this).focus();
            $(this).autocomplete( "search", "" );
        });
        
        button.click(function(){
            input.focus();
            input.autocomplete( "search", "" );
        });
           
    });

});