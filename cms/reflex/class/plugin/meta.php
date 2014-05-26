<?

namespace Infuso\Cms\Reflex\Plugin;
use Infuso\Core;

class Meta extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }

	public function metaObject() {
        $item = $this->component();
        return \Infuso\Cms\Reflex\Model\Meta::get(get_class($item).":".$item->id());
	}
    
    public function create() {
        $item = $this->component();
        $hash = get_class($item).":".$item->id();
        $meta = service("ar")->create("\\Infuso\\Cms\\Reflex\\Model\\Meta", array(
            "hash" => get_class($item).":".$item->id(),
        ));
        app()->msg($meta->id());
    }
    
    public function factory() {
        return $this;
    }

}
