<?

namespace Infuso\SocialAuth\Controller;
use \Infuso\Core;

/**
 * Контроллер для авторизации через соцсети
 **/
class Main extends Core\Controller {

    public function controller() {
        return "socialauth";
    }

    public function indexTest() {
        return true;
    }
    
    public function index_test() {
        app()->tm("/socialauth/test")->exec();
    }

}
