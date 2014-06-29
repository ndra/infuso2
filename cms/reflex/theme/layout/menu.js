mod.init(".rfgwepfkds", function() {
    
    var $container = $(this);

    // Метод, сохраняющий контент левого меню в хранилище сессии
    var storeMenuHTML = function() {
        var html = $container.html();
        sessionStorage.setItem("reflex/left-menu-html", html);
    }
    
    setInterval(storeMenuHTML, 500);
    
    // Восстанавливаем контент левого меню из хранилища сессии
    // Далее этот контент будет заменен загруженным с сервера
    $(".rfgwepfkds").html(sessionStorage.getItem("reflex/left-menu-html"));

    // Делаем запрос сервер для получения контента меню
    var load = function() {
        mod.call({
            cmd:"infuso/cms/reflex/controller/menu/root",
            stored: $container.html(),
            url: window.location.href,
            tab: sessionStorage.getItem("reflex/left-menu-tab")
        }, function(html) {
            $container.html(html);
        });
    };
    
    load();
    
    $container.on("reflex/tab", function(event) {
        sessionStorage.setItem("reflex/left-menu-tab", event.tab);
        load();
    });
    
});