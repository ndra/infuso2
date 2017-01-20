<?

namespace Infuso\User;
use \Infuso\Core;

/**
 * Служебный класс - обработчик событий
 **/
class Handler implements Core\Handler {
    
    public static function clear() {
    
        service("user")->deleteUnverfiedUsers();
        
        \Infuso\User\Model\Token::all()
            ->lt("expires", \Infuso\Core\Date::now())
            ->delete();
        
    }
    
    /**
     * Метод, в котором реализуется бизнес-логика инициализации
     * @handler = infuso/deploy
     * @handlerPriority = -1
     **/
    public static function onDeploy() {
    
		$operations = \Infuso\User\Model\Operation::all();
		$operations->delete();
		
		\Infuso\User\Model\Role::create("admin", "Администратор");
    
        service("task")->add(array(
            "class" => get_class(),
            "method" => "clear",
            "crontab" => "0 0 * * *",
            "title" => "Очистка юзеров и токенов",
            "randomize" => 120,
        ));
    }

}
