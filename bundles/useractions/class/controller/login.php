<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для логина
 **/
class Login extends Core\Controller {

    public function controller() {
        return "login";
    }

    public function indexTest() {
        return true;
    }
    
    public function postTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/login")->exec();
    }
    
    public function post_login($p) {
	
        $email = mb_strtolower(trim($p["data"]["email"]));
        $pass = trim($p["data"]["password"]);
        $user = service("user")->byEmail($email);
        
        if(!$user->verified()) {
            return false;
        }

        if($user->checkPassword($pass)) {
            $user->activate($keep);
            return true;
        }

        return false;
    }

}
