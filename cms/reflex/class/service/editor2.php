<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;
use \mod,\user;

class Editor2 extends Core\Service {

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
            $obj = new $class;
            $ritems[$class] = $obj->root();
        }
        

        foreach($ritems as $class => $items) {
        
            //Если не объект и не масив
            if(!is_object($items) && !is_array($items)) {
                throw new Exception("Метод reflex_root() вернул недопустимое значение");
            }

            if(is_object($items)) {
                $items = array($items);
            }

            foreach($items as $collection) {
		        $event->add(array(
		            "template" => "/reflex/root",
		            "templateParams" => array(
		                "class" => $class,
		                "title" => $collection->title(),
		                "collectionID" => $collection->param("id"),
					),
				));
            }

        }

        Core\Profiler::endOperation();

    }

}
