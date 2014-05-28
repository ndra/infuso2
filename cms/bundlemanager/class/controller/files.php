<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/

class Files extends Core\Controller {

	public function postTest() {
	    return true;
	}
	
	public function post_right($p) {
        return \tmp::get("/bundlemanager/files-right")
            ->param("bundle", service("bundle")->bundle($p["bundle"]))
            ->getContentForAjax();
	}

}
