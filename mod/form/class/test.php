<?

namespace Infuso\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
class Test extends Core\Controller {

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/form/test/")->exec();
    }

}
