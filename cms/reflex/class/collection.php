<?

namespace Infuso\Cms\Reflex;
use Infuso\Core;

class Collection extends Core\Component {

	private $className = null;
	private $method = null;
	private $id = null;

	public function __construct($class,$method,$id = null) {
	    $this->className = $class;
	    $this->method = $method;
	    $this->id = $id;
	}
	
	/**
	 * @todo безопасностью здесь и не пахнет
	 **/
	public function collection() {
		$editor = Editor::get($this->className.":".$this->id);
		$fn = $this->method;
		return $editor->$fn();
	}
	
	public function serialize() {
	    return $this->className.":".$this->method.":".$this->id;
	}
	
	public function unserialize($key) {
	
	    if(!$key) {
	        throw new \Exception("Collection::unserialize() void key");
	    }
	
		list($class,$method,$id) = explode(":",$key);
		return new self($class, $method, $id);
	}
	
	/**
	 * Примерняет параметры к коллекции
	 **/
	public function applyParams($params) {
	    $this->param("viewMode",$params["viewMode"]);
	}
	
	/**
	 * Возвращает класс редактора
	 **/
	public function editorClass() {
	
		$map = \infuso\core\file::get(Core\Mod::app()->varPath()."/reflex/editors.php")->inc();

        if(!$class) {

            $classes = $map[$this->collection()->itemClass()];
            if(!$classes) {
                $classes = array();
            }

            $class = end($classes);

        }

        if(!$class) {
        	$editor = new Reflex\NoneEditor;
            return $editor;
        }

        return new $class;
	
	}
	
	/**
	 * Возвращает виртуальный редактор
	 **/
	public function editor() {
	    $class = $this->editorClass();
	    return new $class;
	}
	
    /**
     * Возвращает массив редакторов элементов
     **/
    public function editors() {

        $class = $this->editorClass();

        $ret = array();
        foreach($this->collection() as $item) {
            $ret[] = new $class($item->id());
        }

        return $ret;

    }

	/**
	 * Возвращает шаблон списка элементов коллекции
	 **/
	public function itemsTemplate() {

		$class = $this->param("reflexEditorClass");
	    $modes = $this->editor()->viewModes();
	    $tmp = $modes[$this->param("viewMode")];

		$tmp = \Infuso\Template\Tmp::get($tmp);
        $tmp->param("collection",$this);
        return $tmp;
	}
	

}