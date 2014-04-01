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
	 * Возвращает виртуальный редактор
	 **/
	public function editor() {
	    $class = $this->className;
	    return new $class;
	}
	
    /**
     * Возвращает массив редакторов элементов
     **/
    public function editors() {

        $class = get_class($this->editor());

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
