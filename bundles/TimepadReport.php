<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class TimepadReport extends Core\Controller {

	public function indexTest() {
	    return Core\Superadmin::check();
	}
    
    public function index() {
        app()->tm("/site/admin/timepad-report")
            ->exec();
    }
    
}
