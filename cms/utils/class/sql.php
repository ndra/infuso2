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
		app()->tm("/admin/utils/sql")->exec();
	}
	
}
