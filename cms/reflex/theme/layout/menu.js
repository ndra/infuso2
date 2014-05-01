$(function() {

    var getExpandedNodes = function() {
        var data = sessionStorage.getItem("reflex/left-menu");
        if(data) {
            return data.split("|||");
        }
        return [];
    }

    mod.call({
        cmd:"infuso/cms/reflex/controller/menu/root",
        expanded: getExpandedNodes(),
        url: window.location.href
    }, function(html) {
        $(".rfgwepfkds").html(html);
    });
    
});