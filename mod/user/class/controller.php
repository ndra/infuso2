<?

namespace Infuso\User;
use \Infuso\Core;

/**
 * Контроллер пользователя
 **/
class Controller extends Core\Controller {

	public function postTest() {
	    return true;
	}
	
    /**
     * Пытается выполнить вход по данному логину (электронной почте) и паролю.
     * Возвращает true/false
     **/
	public function post_login($p) {
	
        $login = strtolower(trim($p["email"]));
        $pass = trim($p["password"]);
        $user = Model\User::byEmail($login);
        
        if(!$user->verified()) {
            app()->msg("Неправильное имя пользователя или пароль");
            return false;
        }

        if($user->checkPassword($pass)) {
            $user->activate($keep);
            return true;
        }

		app()->msg("Неправильное имя пользователя или пароль");
        return false;
	}

    /**
     * Контроллер разлогинивания пользователя
     **/
    public function post_logout($p) {
        $user = \User::active();        
        $user->logout();
    }

}
