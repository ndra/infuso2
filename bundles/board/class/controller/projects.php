<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class Projects extends Base {
    
    public function index() {
        $this->app()->tmp()->exec("/board/projects");
    }

}
