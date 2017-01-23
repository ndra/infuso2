<?

namespace Infuso\Cms\Reflex\Plugin;
use Infuso\Core;
use \Infuso\Cms\Reflex;

class Editor extends Core\Plugin {

    public static function name() {
        return "editor";
    }
    
    public static function componentClass() {
        return "infuso\\activerecord\\record";
    }

    public static function factory($component) {
	
		$map = \infuso\core\file::get(Core\Mod::app()->varPath()."/reflex/editors.php")->inc();

        $itemClass = get_class($component);

        $classes = $map[$itemClass];
        if(!$classes) {
            $classes = array();
        }

        $class = end($classes);

        if(!$class) {
        	$editor = new Reflex\NoneEditor();
            return $editor;
        }

        return new $class($component->id());
        
    }

}
