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
    
    public function index() {
        app()->tm("/user-actions/login")->exec();
    }

}
