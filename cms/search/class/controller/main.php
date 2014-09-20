<?

namespace Infuso\Cms\Search\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля search
 **/

class Main extends Core\Controller {

    public function controller() {
        return "search";
    }

    public function indexTest() {
        return true;
    }
    
    public function index($p) {
        app()->tm("/search/index")
            ->param("query", $p["query"])
            ->exec();
    }

}
