<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Main extends Core\Controller {

    public function controller() {
        return "";
    }

	public function indexTest() {
	    return true;
	}
	
    public function index($p) {   
        app()->tm("/site/index")
            ->exec();
    }
    
}
