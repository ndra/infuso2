<?

namespace Infuso\Cms\Utils\Heartbeat;
use Infuso\Core;

class Controller extends Core\Controller {

	public function indexTest() {
	    return Core\Superadmin::check();
	}
	
	public function index() {
		app()->tm("/admin/utils/heartbeat")->exec();
	}

}
