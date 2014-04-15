<?

namespace Infuso\Cms\Utils;

/**
 * Контроллер для выполнения запросов sql
 **/
class Sql extends \Infuso\Core\Controller {

	public function indexTest() {
	    return \infuso\core\superadmin::check();
	}
	
	public function index() {
	    \tmp::exec("/admin/utils/sql");
	}
	
}
