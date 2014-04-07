<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Bargain extends Core\Controller {

	public static function indexTest() {
		return true;
	}
	
	public function index() {
	    $this->app()->tmp()->exec("/heapit/bargain-list");
	}
	
	public function index_add() {
	    $this->app()->tmp()->exec("/heapit/bargain-new");
	}

}
