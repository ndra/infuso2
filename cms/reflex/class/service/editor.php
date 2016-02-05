<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;
use \mod,\user;

class Editor extends Core\Service implements Core\Handler {

    public function defaultService() {
        return "reflex";
    }

	public function root($tab) {
	
	    // Вызываем событие - сбор меню каталоге
	    $event = new menuCollectEvent();
	    $event->fire();
	    
	    return $event->items($tab);
	}
	
    /**
     * @handler = reflexMenu
     **/
    public function buildMap($event) {

        Core\Profiler::beginOperation("reflex","buildMap",1);
        
        $items = array();

        foreach(service("classmap")->map("Infuso\\Cms\\Reflex\\Editor") as $class) {
            $a = $class::inspector()->annotations();
            foreach($a as $fn => $annotations) {
                if($annotations["reflex-root"] == "on") {                        
                    $collection = new \Infuso\Cms\Reflex\Collection($class, $fn);
                    $items[] = array(
			            "template" => "/reflex/menu-root",
			            "tab" => $annotations["reflex-tab"],
                        "group" => $annotations["reflex-group"],
			            "templateParams" => array(
			                "class" => $class,
							"method" => $fn,
			                "title" => $collection->collection()->title(),
			                "collection" => $collection,
						),
					);
	                /*$event->add();
                    $event->add(array(
                        "template" => "/reflex/menu-group",    
                        "tab" => $annotations["reflex-tab"],
                        "templateParams" => array(
                            "title" => $annotations["reflex-group"],
                        ),
                    ));  */
                }
            }
            
        }
        
        usort($items, function($a, $b) {
            if($ret = strcmp($a["tab"], $b["tab"])) {
                return $ret;
            }
            return strcmp($a["group"], $b["group"]);
        });
        
        foreach($items as $item) {
            if($item["group"] != $lastGroup || $item["tab"] != $lastTab) {
                if($item["group"]) {
                    $event->add(array(
                        "template" => "/reflex/menu-group",    
                        "tab" => $item["tab"],
                        "templateParams" => array(
                            "title" => $item["group"],
                        ),
                    )); 
                }
                $lastTab = $item["tab"];
                $lastGroup = $item["group"];
            }
            $event->add($item);
        }

        Core\Profiler::endOperation();

    }

}
