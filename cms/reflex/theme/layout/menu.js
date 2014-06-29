$(function() {

    // Метод, сохраняющий контент левого меню в хранилище сессии
    var storeMenuHTML = function() {
        var html = $(".rfgwepfkds").html();
        sessionStorage.setItem("reflex/left-menu-html", html);
    }
    
    setInterval(storeMenuHTML, 500);
    
    // Восстанавливаем контент левого меню из хранилища сессии
    // Далее этот контент будет заменен загруженным с сервера
    $(".rfgwepfkds").html(sessionStorage.getItem("reflex/left-menu-html"));

    // Делаем запрос сервер для получения контента меню
    mod.call({
        cmd:"infuso/cms/reflex/controller/menu/root",
        stored: $(".rfgwepfkds").html(),
        url: window.location.href
    }, function(html) {
        $(".rfgwepfkds").html(html);
    });
    
    
});