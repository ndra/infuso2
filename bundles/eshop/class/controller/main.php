<?

namespace Infuso\Eshop\Controller;
use Infuso\Core;

/**
 * Модель группы для интернет-магазина
 **/
class Main extends Core\Controller {

    public function controller() {
        return "eshop";
    }

    public function indexTest() {
        return true;
    }
    
    public function index() {
        app()->tm("/eshop/index")->exec();
    }

}
