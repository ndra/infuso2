$(function(){
    $(".autocomplete-jk7zsaj00t").mod("init", function(){
        var input = $(this).find("input[type='text']");
        var hiddenInput = $(this).find("input[type='hidden']");
        var button = $(this).find("div"); 
        var sourceUrl = input.attr("widget:cmd");
        
        input.autocomplete({
            delay: 500,
            minLength: 0,
            source: function(request, response) {
                //в request.term лежит то что юзер ввел в поле поиска
                mod.call({cmd: sourceUrl , query: request.term}, function(data){
                    //мапим данные ответа
                    var reponseData = $.map(data.suggestions, function(m) {
                        return {
                            value: m.value,
                            key: m.key,
                        };
                    });
                    
                    //ф-ция reponse принимае массив  опциии 
                    response(reponseData);    
                });    
            },
            select: function( event, ui ) { hiddenInput.val(ui.item.key); }
        });
        
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