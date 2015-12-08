<?

namespace Infuso\Earb\Controller;
use \Infuso\Core;

/**
 * Контроллер для управления заказом
 **/
class Main extends Core\Controller {

    public function controller() {
        return "earb";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/earb/index")->exec();
    }
    
    public function index_test() {
        app()->tm("/earb/test")->exec();
    }
    
    public function index_bass() {
        app()->tm("/earb/bass")->exec();
    }
    
    public function index_epic() {
        app()->tm("/earb/epic")->exec();
    }

}
