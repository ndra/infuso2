<?

namespace Infuso\Cms\Reflex\Plugin;
use Infuso\Core;

class Meta extends Core\Plugin {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }
    
    public static function factory($component) {
        return new self($component);
    }
    
    public static function name() {
        return "meta";
    }
    
    public static function componentClass() {
        return "infuso\\actionrecord\\record";
    }

	public function metaObject() {
        $item = $this->component();
        return \Infuso\Cms\Reflex\Model\Meta::get(get_class($item).":".$item->id());
	}

    public function getOrCreateMetaObject() {
        $item  = $this->metaObject();
        if(!$item->exists()){
            $item = $this->create();
        }
        return $item;
    }

    /** 
     * @todo сделать какойто агрегатор для установки/получения всех мет за раз  [Алексюшка]
     **/

    public function title() {
        $item  = $this->getOrCreateMetaObject();
        $args = func_get_args();
        if(count($args)){
            $title = $args[0];
            $item->data("title", $title);
        }
        return $item->data("title");
    }

    public function head() {
        $item  = $this->getOrCreateMetaObject();
        $args = func_get_args();
        if(count($args)){
            $title = $args[0];
            $item->data("head", $title);
        }
        return $item->data("head");
    }
	
	public function keywords() {
        $item  = $this->getOrCreateMetaObject();
        $args = func_get_args();
        if(count($args)){
            $title = $args[0];
            $item->data("keywords", $title);
        }
        return $item->data("keywords");
    }
	
	public function description() {
        $item  = $this->getOrCreateMetaObject();
        $args = func_get_args();
        if(count($args)){
            $title = $args[0];
            $item->data("description", $title);
        }
        return $item->data("description");
    }
	
	
	public function noindex() {
        $item  = $this->getOrCreateMetaObject();
        $args = func_get_args();
        if(count($args)){
            $val = $args[0];
            $item->data("noindex", $val);
        }
        return $item->data("noindex");
    }

    public function create() {
        $item = $this->component();
        $hash = get_class($item).":".$item->id();
        $meta = service("ar")->create("\\Infuso\\Cms\\Reflex\\Model\\Meta", array(
            "hash" => $hash,
        ));
        return $meta;
    }

}
