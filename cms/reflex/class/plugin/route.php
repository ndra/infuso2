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

    /**
     * Возвращает роут
     * Если роута нет, возвращается несуществующий объект
     **/
	public function routeObject() {
        $item = $this->component();
        return \Infuso\Cms\Reflex\Model\Route::get(get_class($item).":".$item->id());
	}

    public function getOrCreateRouteObject($params = array("auto" => false)) {
        $item  = $this->routeObject();
        if(!$item->exists()){
            $item = $this->create($params);
        }
        return $item;
    }   

    /**
     * Создает роут
     **/
    private function create($params = array()) {
        $item = $this->component();
        $hash = get_class($item).":".$item->id();        
        $params["hash"] = $hash;
        $meta = service("ar")->create("\\Infuso\\Cms\\Reflex\\Model\\Route", $params);
        return $meta;
    }
    
    public function setUrl($url) {
    
        if(!$url && !$this->routeObject()->exists()) {
            return;
        }
    
        $item = $this->getOrCreateRouteObject();
         if($url) {
            $item->data("url", $url);
        } else {
            $item->delete();
        }
    }
    
    /**
     * Устанавливает url для объекта
     * url будет помечен как автоматический и будет установлен только если не существует ручной урл
     **/
    public function setUrlAuto($url) {
    
        if(!$url && !$this->routeObject()->exists()) {
            return;
        }
    
        $item = $this->getOrCreateRouteObject(array(
            "auto" => true,
        ));
        if($item->data("auto")) {
            if($url) {
                $item->data("url", $url);
            } else {
                $item->delete();
            }
        }
    }
    
    /**
     * Удаляет роут
     **/
    public function removeUrl() {
        $this->routeObject()->delete();
    }
    
    public function reset() {
        $item = $this->component();    
        if(is_a($item, "infuso\\cms\\reflex\\autoroute")) {
            $this->removeURL();
            $url = $item->generateURL();
            $this->setURLAuto($url);
        } else {
            $this->removeURL();
        }
    }
    
    public function factory() {
        return $this;
    }

}
