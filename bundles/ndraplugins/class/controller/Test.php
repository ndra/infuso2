<?

namespace NDRA\Plugins\Controller;
use \Infuso\Core;

/**
 * Контроллер вывода копирайта ndra
 **/
 
class Test extends Core\Controller {

    public function indexTest() {
        return \Infuso\Core\Superadmin::check();
    }
    
    public function index_slideshow() {
        app()->tm("/ndraplugins/test/slideshow")
            ->exec();        
    }
    
    public function index_video() {
        app()->tm("/ndraplugins/test/video")
            ->exec();        
    }

}
