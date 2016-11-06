<?

namespace Infuso\Cms\Reflex;
use Infuso\Core;

class Collection extends Core\Component {

	private $className = null;
	private $method = null;
	private $id = null;

	public function __construct($class, $method, $id = null) {
	    $this->className = $class;
	    $this->method = $method;
	    $this->id = $id;
	}
    
    public function method() {
        return $this->method;
    }
	
	/**
	 * Возвращает коллекцию элементов (ActiveRecord\Collection)
	 * @todo безопасностью здесь и не пахнет
	 **/
	public function collection() {
    
		$editor = Editor::get($this->className.":".$this->id);
		$fn = $this->method;
		$collection = $editor->$fn();     
        
        $class = $this->editorClass();
        $virtual = new $class;

		// Учитываем поиск
        if($q = $this->param("query")) {
            $virtual->applyQuickSearch($collection, $q);
        }   
        
        // Учитываем фильтры
        $filters = array_values($virtual->filters($collection->copy()));
        $collection = $filters[$this->param("filter")];
        if(!$collection) {
            $collection = $filters[0];
        }
        
        // Учитываем страницу
        $collection->page($this->param("page"));

        return $collection;
	}

	public function collectionWithoutRestrictions() {
		$editor = Editor::get($this->className.":".$this->id);
		$fn = $this->method;
		$collection = $editor->$fn();
        return $collection;
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

        if($query = trim($params["query"])) {
            $this->param("query", $query);
        }
        
        $this->param("filter", $params["filter"]);
        
        $this->param("page", $params["page"]);

	}
	
	/**
	 * Возвращает класс редактора
	 **/
	public function editorClass() {
	
		$map = \infuso\core\file::get(Core\Mod::app()->varPath()."/reflex/editors.php")->inc();

        if(!$class) {

            $classes = $map[$this->collectionWithoutRestrictions()->itemClass()];
            if(!$classes) {
                $classes = array();
            }

            $class = end($classes);

        }

        if(!$class) {
        	$editor = new NoneEditor;
            return $editor;
        }

        return new $class;
	
	}
	
	/**
	 * Возвращает виртуальный редактор
	 **/
	public function editor() {
	    $class = $this->editorClass();
	    $editor = new $class;
	    $editor->item()->setData($this->collection()->eqs());
	    return $editor;
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
        if(!$tmp) {
            reset($modes);
            $tmp = current($modes);
        }

		$tmp = app()->tm($tmp);
        $tmp->param("collection",$this);
        return $tmp;
	}
	
    public function filterTemplate() {
		$tmp = app()->tm("/reflex/shared/collection/items/ajax/filters");
        $tmp->param("collection", $this);
        return $tmp;
    }
    
    public function pagerTemplate() {
		$tmp = app()->tm("/reflex/shared/collection/items/ajax/pager");
        $tmp->param("collection", $this);
        return $tmp;
    }
    
    /**
     * Возвращает флаг сортируемости коллекции
     **/
    public function sortable() {
        return $this->collection()->param("sort");
	}

}
