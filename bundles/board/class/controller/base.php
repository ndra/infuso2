<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

abstract class Base extends Core\Controller {

    public function indexTest() {
        return app()->user()->checkAccess("board/showInterface");        
    }
    
    public function indexFailed() {
        $this->app()->tm()->exec("/board/login");
    }
    
    public function postTest() {
        return app()->user()->checkAccess("board/showInterface");  
    }
}
