<?

namespace Infuso\Site\Controller;
use Infuso\Site\Model\Event as Event;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Main extends Core\Controller {

	public function indexTest() {
	    return true;
	}
	
    public function postTest() {
        return true;
    }
    
    public function index_test() {
    
        app()->tm()->add("center","/site/test");

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    
    public function index_speakers() {
    
        app()->tm()->add("center","/site/speakers/all");

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
	
	public function index_top10() {
        
        $events = Event::all()
            ->applyQuery(array(
                "supercategory" => "top10"
            ));
        
        app()->tm()->add("center","/site/shared/discount-banner/");    
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
        
	}
    
    public function index_kids() {
    
        $events = Event::all()
            ->applyQuery(array(
                "supercategory" => "kids"
            ));               
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    public function index_alacarte() {
    
        $events = Event::all()
            ->applyQuery(array(
                "supercategory" => "alacarte"
            ));
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    public function index_new() {
    
        $events = Event::all()
            ->applyQuery(array(
                "supercategory" => "new"
            ));
            
        app()->tm()->add("center", "/site/shared/events-head/page",array(
            "title" => "Новинки Сити Класс",
            "countTitle" => self::textCourse($events->count()),
            "events" => $events,
        ));    
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    public function index_search($p) {
    
        $events = Event::all()
            ->applyQuery(array(
                "search" => $p["search"],
            ));
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    public function index_calendar($p) {
        $events = Event::all()
            ->applyQuery(array(
                "date" => $p["date"],
            ));
            
        app()->tm()->add("center","/site/events-list",array(
            "events" => $events,
        ));

        app()->tm()->param("right-column", true);    
		app()->tm()->param("top-for-index", true); 
		app()->tm()->param("top-right-sidebar", false); 	

        app()->tm("/site/layout")->exec();
    }
    
    public function post_loadEvents($p) {
    
        $query = json_decode($p["query"], 1);
        
        $events = Event::all()
            ->applyQuery($query);
            
        $events->page($p["page"]);
        $events2 = $events->copy()->page($p["page"] * 1 + 1);
    
        $ret = array(
            "events" => array(),
        );
        
        $ret["html"]= app()->tm("/site/events-list/events-ajax")
            ->param("events", $events)
            ->getContentForAjax();
        
        foreach($events2 as $event) {
            $ret["next"] = true;
            break;
        }
        
        return $ret;
        
    }
    
    /**
     * Возвращает кол-во курсов с правильным склонением, 
     **/ 
   public function textCourse($count){
       
        if(!$count){
            return false;   
        }
        
        $a = $count % 10;
        $b = $count % 100;
    
        switch(true) {
            case($a == 0 || $a >= 5 || ($b >= 10 && $b <= 20)):
                $result = "курсов";
                break;
            case($a == 1):
                $result = "курс";
                break;
            case($a >= 2 && $a <= 4):
                $result = "курса";
                break;
        }

        return $result;
        
    }
	
	
}
