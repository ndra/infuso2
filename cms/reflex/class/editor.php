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
    public function index_log($p) {
        $class = get_called_class();
        $editor = new $class($p["id"]);
		app()->tm("/reflex/log")->param("editor",$editor)->exec();
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
        foreach($this->fields() as $field) {
            if($field->typeID() == "knh9-0kgy-csg9-1nv8-7go9") {
                return $field->field()->name();
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
        list($class,$id) = explode(":",$index);
        return new $class($id);
    }
    
    public function id() {
        return get_class($this).":".$this->itemId();
    }

    /**
     * Возвращает id элемента (id записи activeRecord)
     **/
    public function itemID() {
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
    public function _url($p=array()) {
        $url = \mod::action(get_class($this),"index",array("id"=>$this->itemID()))->params($p)->url();
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
        return User::active()->checkAccess("reflex:editItem",array(
            "editor" => $this,
        ));
    }

    /**
     * @todo Сделать перенос объектов в корзину, а не простое их удаление
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

    /**
     * Триггер, вызывающийся перед созданием элемента через каталог
     * Контекст - виртуальный объект
     **/
    public function _beforeCreate($data) {
        return $this->beforeEdit();
    }
    
    public function setData($data) {
    
        $item = $this->item();
        foreach($data as $key => $val) {
            $item->data($key,$val);
        }
        
        app()->msg("Объект изменен");
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
        
        $menu[] = array(
            "href" => $this->url(),
            "title" => "Редактирование",
        );
        
        if($this->logEnabled()) {
            $menu[] = array(
                "href" => \mod::action(get_class($this),"log",array("id"=>$this->itemID()))->url(),
                "title" => "Лог",
            );
        }
        
        if($this->metaEnabled()) {
            $menu[] = array(
                "href" => \mod::action(get_class($this),"meta",array("id"=>$this->itemID()))->url(),
                "title" => "Метаданные",
            );
        }
        
        $class = get_class($this);
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $editor = $this;
                $collection = $editor->$fn();
                $menu[] = array(
                    "href" => \mod::action(get_class($this),"child",array("id"=>$this->itemID(),"method" => $fn))->url(),
                    "title" => $collection->title(),
                    "count" => $collection->count(),
                );
            }
        }
        
        return $menu;
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
		return app()->tm("/reflex/editor/content/fields/form")->param("editor",$this);
    }
    
    public function templateEditBeforeForm() {
        return app()->tm("/reflex/noop");
    }
    
    /**
     * Возвращает массив объектов fieldView - представлений полей
     **/         
    public function fields() {
    
        $fields = array();
        foreach($this->item()->fields() as $field) {
            $fields[] = FieldView\View::get($field);
        }
        return $fields;
                                        
    }
    
    public function metaEnabled() {
        return false;
    }
    
    public function logEnabled() {
        return true;
    }
    
    public function setMeta($p) {
        $this->item()->plugin("meta")->metaObject()->setData($p);
    }
    
    public function deleteMeta() {
        $this->item()->plugin("meta")->metaObject()->delete();
    }
    
    public function filters($collection) {
        return array (
            "Все элементы" => $collection->copy(),
        );
    }
    
}
