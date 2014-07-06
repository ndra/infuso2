<?

namespace Infuso\Heapit\Controller;
use \Infuso\Core;

class Main extends Base {

    public function index() {
        $this->app()->tm()->exec("/heapit/index");
    }

    public function index_test() {
        $u = new \Infuso\Update\Updater();
        var_export($u->params());
    }

}
