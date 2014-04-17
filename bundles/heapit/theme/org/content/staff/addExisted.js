$(function(){
    $(".addExisted-elco99cxzm").click(function(event){
        event.preventDefault();
        var popUp = $(".popup-ejmhyas19m");
        popUp.show();
        var top = event.offsetY - popUp.get(0).scrollHeight/2;
        var left = event.offsetX + $(this).position().left-14;
        popUp.css({top: top, left: left});
    });
});