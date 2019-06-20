<?

namespace Infuso\ReCaptcha\Controller;
use \Infuso\Core;

class Main extends Core\Controller {

    public function controller() {
        return "test";
    }

    public function index() {
        app()->tm("/recaptcha/test")->exec();
    }
    
}
