<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для управления заказом
 **/
class Registration extends Core\Controller {

    public function controller() {
        return "registration";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/registration")->exec();
    }

}
