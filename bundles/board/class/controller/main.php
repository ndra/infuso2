<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class Main extends Base {

    public function controller() {
        return "board";
    }

    public  function index() {
        $this->app()->tm()->exec("/board/worker");
    }

    public  function index_sorttest() {
        $this->app()->tm()->exec("/board/sort");
    }

}
