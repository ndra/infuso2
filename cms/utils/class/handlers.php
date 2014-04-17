<?

namespace Infuso\Cms\Utils;

/**
 * Контроллер для выполнения запросов sql
 **/
class Handlers extends \Infuso\Core\Controller {

	public function indexTest() {
	    return \Infuso\Core\Superadmin::check();
	}
	
	public function index() {
	    \tmp::exec("/admin/utils/handlers");
	}
	
}
