<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Контроллер для документации
 **/

class Doc extends Core\Controller {

    public function controller() {
        return "doc";
    }

	public function indexTest() {
        return \Infuso\Core\Superadmin::check();
	}
    
    
    public function index() {
        app()->tm("/bundlemanager/doc")
            ->exec();
    }
    
    /**
     * Контроллер списка классов в бандле
     **/
    public function index_bundle($p) {                        
        $bundle = service("bundle")->bundle($p["bundle"]);    
        app()->tm("/bundlemanager/doc-bundle")
            ->param("bundle", $bundle)
            ->exec();
    }
    
    public function index_class($p) {
        app()->tm("/bundlemanager/doc-class")
            ->param("class", $p["class"])
            ->exec();
        
    }

}
