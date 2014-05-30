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
    
	public function post_list($p) {
        return \tmp::get("/bundlemanager/files-right/nodes")
            ->param("path", \file::get($p["path"]))
            ->getContentForAjax();
	}
    
    public function post_editor($p) {
        return \tmp::get("/bundlemanager/file-editor")
            ->param("path", \file::get($p["path"]))
            ->getContentForAjax();
    }

}
