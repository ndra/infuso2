$(function() {

    // Метод, сохраняющий контент левого меню в хранилище сессии
    var storeMenuHTML = function() {
        var html = $(".rfgwepfkds").html();
        sessionStorage.setItem("reflex/left-menu-html", html);
    }
    
    setInterval(storeMenuHTML, 2000);
    
    // Восстанавливаем контент левого меню из хранилища сессии
    // Далее этот контент будет заменен загруженным с сервера
    $(".rfgwepfkds").html(sessionStorage.getItem("reflex/left-menu-html"));

    // Возвращает список всех раскрытых нод
    var getExpandedNodes = function() {
        var data = sessionStorage.getItem("reflex/left-menu");
        if(data) {
            return data.split("|||");
        }
        return [];
    }

    // Делаем запрос сервер для получения контента меню
    mod.call({
        cmd:"infuso/cms/reflex/controller/menu/root",
        expanded: getExpandedNodes(),
        url: window.location.href
    }, function(html) {
        $(".rfgwepfkds").html(html);
    });
    
    
});