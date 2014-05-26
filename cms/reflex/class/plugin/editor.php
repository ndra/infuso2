<?

namespace Infuso\Cms\Reflex\Plugin;
use Infuso\Core;
use \Infuso\Cms\Reflex;

class Editor extends \Infuso\Core\Component {

    private $component = null;

    public function __construct($component) {
        $this->component = $component;
    }

    public function component() {
        return $this->component;
    }
    
    public function factory() {
	
		$map = \infuso\core\file::get(Core\Mod::app()->varPath()."/reflex/editors.php")->inc();

        $itemClass = get_class($this->component());

        $classes = $map[$itemClass];
        if(!$classes) {
            $classes = array();
        }

        $class = end($classes);

        if(!$class) {
        	$editor = new Reflex\NoneEditor();
            return $editor;
        }

        return new $class($this->component()->id());
        
    }

}
