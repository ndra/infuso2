$(function() {

    var load = function() {
        var itemsList = $(".rpu80rt4m0 .ajax-container");
        var data = {};
        data.cmd = "Infuso/Board/Controller/Task/getTasks";
        mod.call(data, function(data) {
            itemsList.html(data.html);
        }, {
            unique: "32tvfkepng"
        });
        
    }
    
    setTimeout(load,0);
    
    // При нажатии на F5 перегружаем список задач
    
    $(document).keydown(function(event) {
        if(event.which === 116) {
            load();
            event.preventDefault();
        }
    });

}); 