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
        $editor->templateMain()->exec();
    }
    
    /**
     * Контроллер начального списка
     **/
    public function index_root($p) {
        $code = get_class($this).":".$p["method"];
        $collection = Collection::unserialize($code);
        \Infuso\Template\Tmp::exec("/reflex/root2",array(
            "editor" => $this,
            "collection" => $collection,
        ));
    }
    
    /**
     * Контроллер списка дочерних страниц
     **/
    public function index_child($p) {
    
        $class = get_called_class();
        $editor = new $class($p["id"]);
    
        $code = get_class($this).":".$p["method"].":".$editor->itemID();
        $collection = Collection::unserialize($code);
        
        \Infuso\Template\Tmp::exec("/reflex/children",array(
            "editor" => $editor,
            "collection" => $collection,
        ));
    }

    /**
     * Контроллер лога объекта
     **/
    public function index_log($p) {
        $class = get_called_class();
        $editor = new $class($p["id"]);
        \Infuso\Template\Tmp::exec("/reflex/log",array(
            "editor" => $editor,
        ));
    }
    
    /**
     * Контроллер метаданных
     **/
    public function index_meta($p) {
    }
     
    public function title() {
        return $this->item()->title();
    }

    /**
     * Конструктор
     **/
    public function __construct($itemID=null) {
        if(is_object($itemID)) {
            $this->item = $itemID;
        } else {
            $this->item = Core\Mod::service("ar")->get($this->itemClass(),$itemID);
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
            return;
        }

        return $this->component()->beforeEdit();
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
    
    public function _afterChange() {}

    /**
     * Триггер, вызывающийся перед удалением элемента через каталог
     **/
    public function _beforeDelete() {
        return $this->component()->beforeEdit();
    }

    /**
     * Триггер, вызывающийся перед созданием элемента через каталог
     * Контекст - виртуальный объект
     **/
    public function _beforeCreate($data) {
        return $this->component()->beforeEdit();
    }

    public function _afterCreate() {}
    
    public function setData($data) {
    
        $item = $this->item();
        foreach($data as $key => $val) {
            $item->data($key,$val);
        }
        
        Core\Mod::msg("Объект изменен");
    }


    /**
     * Возвращает список дезактивированных функций
     **/
    public final function getDisableItems($list=null) {

        // Отключаем лишние функции
        $disable = $this->disable();
        if(!$disable)
            $disable = array();
        if(is_string($disable))
            $disable = util::splitAndTrim($disable,",");

        // Параметр "disable" коллекции
        if($list) {
            $disable2 = $list->param("disable");
            if(!$disable2) $disable2 = array();
            if(is_string($disable2))
                $disable2 = util::splitAndTrim($disable2,",");
            foreach($disable2 as $item)
                $disable[] = $item;
        }

        // Если выключена кнопка "Добавить", прячем кнопку "Закачать"
        if(in_array("add",$disable)) {
            $disable[] = "upload";
        }

        // Фильтруем уникальные значения
        $disable = array_unique($disable);

        return $disable;
    }

    /**
     * @return Возвращает массив фильтров
     * Пробегается по всем плведениям, вызываеит метод filters() и объединяет результаты
     **/
    public function filters() {
        return $this->callBehaviours("filters");
    }

    public function saveMeta($meta,$langID) {

        $metaObject = $this->item()->metaObject();

        if(!$metaObject->exists()) {
            $hash = get_class($this->item()).":".$this->itemID();
            $obj = reflex::create("reflex_meta_item",array("hash"=>$hash));
        }

        if($meta) {
            foreach($meta as $key => $val) {
                $metaObject->data($key,$val);
            }
        }
    }

    public function group() {
        return $this->item()->data("group");
    }

    public function rootPriority() {
        return 0;
    }

    public function deleteMeta($langID) {

        $metaObject = $this->item()->metaObject();
        $metaObject->delete();
    }

    public function setURL($url) {
        $this->item()->setURL($url);
    }

    public function actionAfterCreate() {
        return "edit/".get_class($this)."/".$this->item()->id();
    }
    
    /**
     * Возвращает список режимов отображения
     **/
    public function _viewModes() {
        return array(
            "Список" => "/reflex/shared/collection/items/grid-ajax",
            "Превью" => "/reflex/shared/collection/items/preview-ajax",
        );
    }
    
    public function menu() {
        $menu = array();
        $menu[] = array(
            "href" => $this->url(),
            "title" => "Редактирование",
        );
        $menu[] = array(
            "href" => \mod::action(get_class($this),"log",array("id"=>$this->itemID()))->url(),
            "title" => "Лог",
        );
        
        $class = get_class($this);
        $a = $class::inspector()->annotations();
        foreach($a as $fn => $annotations) {
            if($annotations["reflex-child"] == "on") {
                $editor = new $class;
                $collection = $editor->$fn();
                $menu[] = array(
                    "href" => \mod::action(get_class($this),"child",array("id"=>$this->itemID(),"method" => $fn))->url(),
                    "title" => $collection->title(),
                );
            }
        }
        
        return $menu;
    }
    
    public function templateMain() {
        return \Infuso\Template\Tmp::get("/reflex/editor",array(
            "editor" => $this,
        ));
    }
    
    /**
     * Возвращает шаьлон формы редактирования элемента
     **/
    public function templateEditForm() {
        return \Infuso\Template\Tmp::get("/reflex/editor/content/fields/form",array(
            "editor" => $this,
        ));
    }

}
