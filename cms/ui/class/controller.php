<?

namespace Infuso\Cms\UI;

/**
 * Стандартная тема модуля reflex
 **/

class Controller extends \Infuso\Core\Controller {

    public function indexTest() { 
        return \Infuso\Core\Superadmin::check();
    }
    
    public function controller() {
        return "uitest";
    }
    
    public function index() {
        app()->tm("/ui/test")
            ->exec();
    }

}
