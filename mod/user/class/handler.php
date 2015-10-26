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
        service("user")->deleteUnverfiedUsers();        
    }
    
    /**
     * Метод, в котором реализуется бизнес-логика инициализации
     * @handler = infuso/deploy
     * @handlerPriority = -1
     **/
    public static function onDeploy() {
    
		$operations = \Infuso\User\Model\Operation::all();
		$operations->delete();
		
		\Infuso\User\Model\Role::create("admin","Администратор");
    
        return;
        reflex_task::add(array(
            "class" => get_class(),
            "method" => "deleteUnverfiedUsers",
            "crontab" => "0 0 * * *"
        ));
    }

}
