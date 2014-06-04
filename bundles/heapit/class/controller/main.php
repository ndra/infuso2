<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Main extends Base {

    public function index() {
        $this->app()->tmp()->exec("/heapit/index");
    }

}
