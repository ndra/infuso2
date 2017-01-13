<?

namespace Infuso\UserActions\Controller;
use \Infuso\Core;

/**
 * Контроллер для восстановлания пароля
 **/
class Recovery extends Core\Controller {

    public function controller() {
        return "password-recovery";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/user-actions/recovery")->exec();
    }

}
