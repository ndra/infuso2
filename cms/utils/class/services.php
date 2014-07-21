<?

namespace Infuso\Cms\Utils;

/**
 * Контроллер для выполнения запросов sql
 **/
class Services extends \Infuso\Core\Controller {

	public function indexTest() {
	    return \Infuso\Core\Superadmin::check();
	}
	
	public function index() {
		app()->tm("/admin/utils/services")->exec();
	}
	
}
