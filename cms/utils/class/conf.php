<?

Namespace Infuso\Cms\Utils;
use Infuso\Core;

/**
 * Контроллер отчета крона
 **/
class Conf extends Core\Controller implements Core\Handler {

	public function indexFailed() {
	    admin::fuckoff();
	}

	public function indexTest() {
	    return Core\Superadmin::check();
	}
	
	public function postTest() {
	    return Core\Superadmin::check();
	}
	
	public function index() {
		app()->tm("/admin/utils/conf")->exec();
	}
    
	public function index_visual() {
		app()->tm("/admin/utils/conf-visual")->exec();
	}
	
	public function post_save($p) {
	    \file::get(app()->confPath()."/components.yml")->put($p["data"]);
	    app()->msg("Настройки сохранены");
	}

}
