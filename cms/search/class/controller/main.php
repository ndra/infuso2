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
    
        $results = service("search")->query($p["query"]);
		
        $results->limit(20);
        $results->addBehaviour("infuso\\cms\\filter");
        $results->applyQuery($p);
		
        return app()->tm("/search/index")
            ->param("query", $p["query"])
            ->param("results", $results)
            ->exec();
    }

}
