<?

namespace Infuso\User;
use \Infuso\Core;

/**
 * Служебный класс - обработчик событий
 **/
class Handler implements Core\Handler {

    public function on_mod_beforeAction() {
        User::active()->registerActivity();
    }
    
    public function on_mod_beforecmd() {
        User::active()->registerActivity();
    }
    
    public static function deleteUnverfiedUsers() {
        mod::service("user")->deleteUnverfiedUsers();        
    }
    
    /**
     * Метод, в котором реализуется бизнес-логика инициализации
     * @handler = infusoInit
     * @handlerPriority = -1
     **/
    public static function onInit() {
    
		$operations = \Infuso\User\Model\Operation::all();
		$operations->delete();
    
        return;
        reflex_task::add(array(
            "class" => get_class(),
            "method" => "deleteUnverfiedUsers",
            "crontab" => "0 0 * * *"
        ));
    }

}
