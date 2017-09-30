<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Тестовый контроллер
 **/
class Test extends Core\Controller {

    public function controller() {
        return "test";
    }

	public function indexTest() {
		return true;
	}
	
	public function index() {
    
        $event =  \infuso\site\model\event::get(12998);
        $event->timepadSync();
  
	}
	

}