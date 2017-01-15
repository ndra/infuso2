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
    
    public function index_test() {
        
        $user = service("user")->get(2);
        
        $token = $user->generateToken(array(
            "type" => "login",
            "lifetime" => 1,
        ));
        
        echo $user->checkToken($token, array(
            "type" => "login",
        ));
        
    }

}
