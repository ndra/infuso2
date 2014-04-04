<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;
use \mod,\user;

class Editor extends Core\Service implements Core\Handler {

    public function defaultService() {
        return "reflex";
    }

	public function root() {
	
	    // �������� ������� - ���� ���� ��������
	    $event = new menuCollectEvent();
	    $event->fire();
	    
	    // �������� ��������� �� reflexRoot()
	    //$this->buildMap($event);

	    return $event->items();
	}
	
    /**
     * @handler = reflexMenu
     **/
    public function buildMap($event) {

        Core\Profiler::beginOperation("reflex","buildMap",1);

        $ritems = array();

        foreach(mod::service("classmap")->map("Infuso\\Cms\\Reflex\\Editor") as $class) {
            $a = $class::inspector()->annotations();
            foreach($a as $fn => $annotations) {
                if($annotations["reflex-root"] == "on") {

                    $collection = new \Infuso\Cms\Reflex\Collection($class,$fn);

	                $event->add(array(
			            "template" => "/reflex/menu-root",
			            "templateParams" => array(
			                "class" => $class,
							"method" => $fn,
			                "title" => $collection->collection()->title(),
			                "collection" => $collection,
						),
					));
                }
            }
        }

        Core\Profiler::endOperation();

    }

}
