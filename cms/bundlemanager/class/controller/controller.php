<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/

class Main extends Core\Controller {

	public function indexTest() {
	    return true;
	}
	
	public function index() {
		\tmp::exec("/bundlemanager/main");
	}

}
