<?

namespace Infuso\Cms\Reflex\Plugin;
use Infuso\Core;

class Route extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

	public function routeObject() {
        $item = $this->component();
        return \Infuso\Cms\Reflex\Model\Route::get(get_class($item).":".$item->id());
	}

    public function getOrCreateRouteObject() {
        $item  = $this->routeObject();
        if(!$item->exists()){
            $item = $this->create();
        }
        return $item;
    }   

    public function create() {
        $item = $this->component();
        $hash = get_class($item).":".$item->id();
        $meta = service("ar")->create("\\Infuso\\Cms\\Reflex\\Model\\Route", array(
            "hash" => $hash,
        ));
        return $meta;
    }
    
    public function setUrl($url) {
        $item = $this->getOrCreateRouteObject();
        $item->data("url", $url);
    }
    
    public function removeUrl() {
        $this->routeObject()->delete();
    }
    
    public function factory() {
        return $this;
    }

}
