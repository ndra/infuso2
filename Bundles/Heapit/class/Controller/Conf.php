<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Conf extends Base {
    
    public function index() {
        $this->app()->tmp()->exec("/heapit/conf");
    }    
        
}
