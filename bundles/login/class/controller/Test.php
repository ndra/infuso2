<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Тестовый контроллер Сайта
 **/
class Test extends Core\Controller {

    public function controller() {
        return "test";
    }

	public function indexTest() {
	    return true;
	}
	
    public function index($p) {   
        app()->tm("/site/test")
            ->exec();
    }
    
}
