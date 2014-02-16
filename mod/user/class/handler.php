<?

/**
 * Служебный класс - обработчик событий
 **/
class user_handler implements mod_handler {

    public function on_mod_beforeAction() {
        user::active()->registerActivity();
    }
    
    public function on_mod_beforecmd() {
        user::active()->registerActivity();
    }
    
    public static function deleteUnverfiedUsers() {
        mod::service("user")->deleteUnverfiedUsers();        
    }
    
    /**
     * Метод, в котором реализуется бизнес-логика инициализации
     * @handler = infusoInit
     * @handlerPriority = 0
     **/
    public static function onInit() {
        reflex_task::add(array(
            "class" => "user_handler",
            "method" => "deleteUnverfiedUsers",
            "crontab" => "0 0 * * *"
        ));
    }

}
