<?

Namespace Infuso\Cms\Utils;
use Infuso\Core;

/**
 * Контроллер отчета крона
 **/
class Cron extends Core\Controller implements Core\Handler {

	public function indexFailed() {
	    admin::fuckoff();
	}

	public function indexTest() {
	    return Core\Superadmin::check();
	}
	
	public function index() {
	    \tmp::exec("/admin/utils/cron");
	}

}
