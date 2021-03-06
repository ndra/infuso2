<?

namespace Infuso\Cms\Reflex;
use Infuso\Core;
use User;

abstract class Editor extends Core\Controller {

    private $item;
    
    /**
     * @todo Сделать репльную проверку
     **/
    public function indexTest() {
        return true;
    }
    
    /**
     * Контроллер редактирования элемента
     **/
    public function index($p) {
        $class = get_called_class();
        $editor = new $class($p["id"]);
        
        if(!$editor->beforeView()) {
            $editor->templateNoAccess()->exec();
            return;
        }
        
        $editor->templateMain()->exec();
    }
    
    /**
     * Задает элементы, которые будут отображены на странице редактирования
     * Возможные варианты
     * form - стандартная форма редактирования
     * collection:method - коллекция, заданная методом method
     * Также можно написать строку с произвольным html-кодом, которая будет выведена «как есть»
     **/
	public function _layout() {
	    return array(
			"form",
		);
	}
    
    /**
     * Контроллер начального списка
     **/
    public function index_root($p) {
        $code = get_class($this).":".$p["method"];
        $collection = Collection::unserialize($code);
        app()->tm("/reflex/root")->param(array(
            "editor" => $editor,
            "collection" => $collection,
        ))->exec();
    }
    
    /**
     * Контроллер списка дочерних страниц
     **/
    public function index_child($p) {
        $class = get_called_class();
        $editor = new $class($p["id"]);
        $code = get_class($this).":".$p["method"].":".$editor->itemID();
        $collection = Collection::unserialize($code);
		app()->tm("/reflex/children")->param(array(
            "editor" => $editor,
            "collection" => $collection,
        ))->exec();
    }

    /**
     * Контроллер лога объекта
     **/
    public function index_meta($p) {
        $class = get_called_class();
        $editor = new $class($p["id"]);   
		app()->tm("/reflex/meta")->param("editor",$editor)->exec();
    }
    
    public function title() {
        return $this->item()->title();
    }
    
    public function _image() {
        // перебираем поля до первого поля типа файл
        $name = $this->fileField();
        if($name) {
            return $this->item()->pdata($name);
        }
        return Core\File::nonExistent();
    }
    
    public function _fileField() {
        // перебираем поля до первого поля типа файл
        foreach($this->item()->fields() as $field) {
            if($field->typeID() == "knh9-0kgy-csg9-1nv8-7go9") {
                return $field->name();
            }
        }
    }

    /**
     * Конструктор
     **/
    public function __construct($itemID = null) {
        if(is_object($itemID)) {
            $this->item = $itemID;
        } else {                                    
            $this->item = service("ar")->get($this->itemClass(),$itemID);
        }
    }
    
    /**
     * Возвращает редактор элемента по индексу
     **/
    public static function get($index) {
        list($class, $id) = explode(":", $index);
        return new $class($id);
    }
    
    public function id() {
        return get_class($this).":".$this->itemId();
    }

    /**
     * Возвращает id элемента (id записи activeRecord)
     **/
    public function itemId() {
        return $this->item()->id();
    }

    /**
     * Возвращает класс редактируемого элемента
     **/
    public function itemClass() {
        return preg_replace("/\_editor$/","",get_class($this));
    }

    /**
     * Возвращает редактируемый объект reflex
     **/
    public final function item() {
        return $this->item;
    }

    /**
     * Возвращает url для редактирвоания объяекта
     **/
    public function _url() {
    
        $method = Keeper::get(get_class($this), $this->itemID());
        
        if($method) {
            return (new \Infuso\Core\Action(get_class($this), "child"))
                ->param("method", $method)
                ->param("id", $this->itemId())
                ->url();
        }
    
        $url = \mod::action(get_class($this), "index", array("id" => $this->itemID()))->url();
        return $url;
    }

    /**
     * Триггер, вызывающийся перед просмотром коллекции
     * Контекст в этом случае - виртуальный элемент коллекции
     **/
    public function _beforeCollectionView() {
        return $this->beforeEdit();
    }

    /**
     * Триггер, вызывающийся перед просмотром элемента
     **/
    public function _beforeView() {

        if(!$this->item()->exists()) {
            return false;
        }

        return $this->beforeEdit();
    }

    /**
     * Триггер, вызывающийся перед редактированием элемента
     * Редактирование элемента - любые изменения объекта через каталог
     **/
    public function _beforeEdit() {
        return app()->user()->checkAccess("reflex:editItem",array(
            "editor" => $this,
        ));
    }

    /**
     * @todo Сделать проверку безопасности! Сделать перенос объектов в корзину, а не простое их удаление
     **/         
    public function delete() {

        $this->item()->delete();

        /*if($editor->beforeEdit()) { // Проверяем возможность удаления объекта

            $item->log("Объект {$item->title()} удален");
            if(get_class($item)!="reflex_editor_trash") {
                $trash = reflex::create("reflex_editor_trash",array(
                    "title" => $item->title(),
                    "data" => json_encode($item->data()),
                    "meta" => json_encode($item->metaObject()->data()),
                    "img" => $item->editor()->img(),
                    "class" => get_class($item),
                ));
            }
            $item->metaObject()->delete();
            $item->delete();
        } else {
            app()->msg("У вас нет прав для удаления этого объекта",1);
        }  */
    }

    /**
     * Триггер, вызывающийся перед удалением элемента через каталог
     **/
    public function _beforeDelete() {
        return $this->beforeEdit();
    }
    
    public function redirectAfterDelete() {
        $parent = $this->item()->parent();
        if(!$parent->exists()) {
            return null;
        }
        return $parent->plugin("editor")->url();
    }

    /**
     * Триггер, вызывающийся перед созданием элемента через каталог
     * Контекст - виртуальный объект
     **/
    public function _beforeCreate($data) {
        return $this->beforeEdit();
    }
    
    public function setData($data) {  
      
        $item = $this->item();
        $item->fill($data);        
        app()->msg("Объект изменен");
        
        $fields = array();
        foreach($item->fields()->changed() as $field) {
            $fields[] = $field->name();
        }
        
        $item->plugin("log")->log(array(
            "message" => "Изменение данных ".implode(", ", $fields),
        ));
    }

    /**
     * Выполняет поиск по коллекции
     **/         
    public function _applyQuickSearch($collection, $search) {

        $item = $this->item();

        $name = null;
        foreach($item->fields() as $field) {
            if($field->name() == "title") {
                $name = "title";
                break;
            }
        }

        if(!$name) {
            foreach($item->fields() as $field) {
                if($field->editable() && $field->typeId() == "v324-89xr-24nk-0z30-r243") {
                    $name = $field->name();
                    break;
                }
            }
        }

        if($name) {
            $collection->like($name, $search);
        }

    }

    /**
     * Возвращает список режимов отображения
     **/
    public function _viewModes() {      
        $ret = [];            
        if(in_array("list", $this->availlableViewModes())) {
            $ret[] = "/reflex/shared/collection/items/ajax/list";
        }             
        if(in_array("thumbnail", $this->availlableViewModes())) {
            $ret[] = "/reflex/shared/collection/items/ajax/preview";
        }           
        return $ret;
    }
    
    public function availlableViewModes() {
        return array(
            "list",
            "thumbnail",
            "grid"
        );
    }
    
    public function listItemTemplate() {
        return app()->tm("/reflex/shared/collection/items/ajax/list/item")
            ->param("editor", $this);
    }
    
    /**
     * Возвращает меню редактора
     * Меню показывается в шапке редактора элемента в каталоге
     **/
    public function menu() {
    
        $menu = array();
        
        $menu["edit"] = array(
            "href" => \mod::action(get_class($this), "index", array("id" => $this->itemID()))->url(),
            "title" => "Редактирование",
        );
        
        if($this->metaEnabled()) {
            $menu["meta"] = array(
                "href" => \mod::action(get_class($this), "meta", array("id" => $this->itemID()))->url(),
                "title" => "Метаданные",
            );
        }
        
        foreach($this->childrenCollections() as $collection) {  
            $menu[] = array(
                "href" => (new \Infuso\Core\Action(get_class($this), "child", array("id"=>$this->itemID(), "method" => $collection->method())))->url(),
                "title" => $collection->collection()->title(),
                "count" => $collection->collection()->count(),
            );      
        }
        
        // Добавляем в модель данные поведений              
        foreach($this->behaviourMethods("menu") as $closure) {
            $menu = array_merge($menu, $closure());
        }
        
        return $menu;
    }
    
    /**
     * Возвращает массив дочерних коллекций
     **/
    public function childrenCollections() {
        $ret = array();
        $class = get_class($this);
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $editor = $this;
                $collection = $editor->$fn();
                if($collection) {
                    $ret[] = new Collection(get_class($this), $fn, $editor->itemId());
                }
            }
        }
        return $ret;
    }
    
    public function templateMain() {
		return app()->tm("/reflex/editor")->param("editor", $this);
    }
    
    public function templateNoAccess() {
        return app()->tm("/reflex/noaccess")->param("editor", $this);
    }
    
    /**
     * Возвращает шаблон формы редактирования элемента
     **/
    public function templateEditForm() {
        $widget = new \Infuso\CMS\Reflex\Widget\Fields();
        $fields = $this->item()->fields()->visible();
        $widget->fields($fields);
        $widget->editor($this);
        return $widget;
    }
    
    public function templateEditBeforeForm() {
        return app()->tm("/reflex/noop");
    }
    
    public function _metaEnabled() {
        return false;
    }
    
    public function logEnabled() {
        return true;
    }
    
    public function filters($collection) {
        return array (
            "Все элементы" => $collection->copy(),
        );
    }
    
    /**
     * @reflex-child = on
     **/
    public function logg() {  
        if($this->logEnabled()) {
            return service("log")
                ->all()
                ->eq("index", get_class($this->item()).":".$this->item()->id())
                ->param("menu", false)
                ->param("title", "Лог");
        }   
    }
    
}