<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;
use \mod,\user;

class Editor extends Core\Service {

    public function defaultService() {
        return "reflex";
    }

	public function root() {
	
	    // Вызываем событие - сбор меню каталоге
	    $event = new menuCollectEvent();
	    $event->fire();
	    
	    // Собираем коллекции из reflexRoot()
	    $this->buildMap($event);

	    return $event->items();
	}
	
    /**
     * Строит карту рутов
     **/
    public function buildMap($event) {

        Core\Profiler::beginOperation("reflex","buildMap",1);

        $ritems = array();

        foreach(mod::service("classmap")->map("Infuso\\Cms\\Reflex\\Editor") as $class) {
            $a = $class::inspector()->annotations();
            foreach($a as $fn => $annotations) {
                if($annotations["reflex-root"] == "on") {

                    $editor = new $class;
                    $collection = $editor->$fn();

	                $event->add(array(
			            "template" => "/reflex/root",
			            "templateParams" => array(
			                "class" => $class,
							"method" => $fn,
			                "title" => $collection->title(),
			                "collection" => $collection,
						),
					));
                }
            }
        }

        Core\Profiler::endOperation();

    }

}
