<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для управления заказом
 **/
class Register extends Core\Controller {

    public function controller() {
        return "register";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/register")->exec();
    }

}
