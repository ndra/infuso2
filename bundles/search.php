<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model\Event as Event;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Search extends Core\Controller {

	public function indexTest() {
	    return true;
	}
	
    public function postTest() {
        return true;
    }
	
	/**
     * Поиск по названию
     *
     * @return void
     **/
    public function index($p = null) {
        
        $search = mysql_real_escape_string($p['search']);
        
        $paramsForCollection = array("controller"=>"search", "search"=>$search);
        $events = Event::eventsForView($paramsForCollection);
		app()->tm()->add("center","/site/title", "результаты поиска: «" . $search . "»");
		app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
            "paramsForCollection" => $paramsForCollection
        ));
        app()->tm()->param("right-column", true);    
        app()->tm("/site/layout")->exec();
    }
	
}
