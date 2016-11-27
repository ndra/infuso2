<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/  
class Main extends Core\Controller {

    public function controller() {
        return "bundlemanager";
    }

	public function indexTest() {
        return \Infuso\Core\Superadmin::check();
	}
    
    public function indexFailed() {
        return \Infuso\CMS\Admin\Admin::fuckoff();
    }
	
	public function index() {
		app()->tm("/bundlemanager/main")->exec();
	}
    
	public function index_todo() {
		app()->tm("/bundlemanager/todo")->exec();
	}

}
