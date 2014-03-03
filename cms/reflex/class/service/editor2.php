<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;
use \mod,\user;

class Editor2 extends Core\Service {

    public function defaultService() {
        return "reflex";
    }

	public function root() {
	
	    // �������� ������� - ���� ���� ��������
	    $event = new menuCollectEvent();
	    $event->fire();
	    
	    // �������� ��������� �� reflexRoot()
	    $this->buildMap($event);

	    return $event->items();
	}
	
    /**
     * ������ ����� �����
     **/
    public function buildMap($event) {

        Core\Profiler::beginOperation("reflex","buildMap",1);

        $ritems = array();

        foreach(mod::service("classmap")->map("Infuso\\Cms\\Reflex\\Editor") as $class) {
            $obj = new $class;
            $ritems[$class] = $obj->root();
        }
        

        foreach($ritems as $class => $items) {
        
            //���� �� ������ � �� �����
            if(!is_object($items) && !is_array($items)) {
                throw new Exception("����� reflex_root() ������ ������������ ��������");
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
