<?

namespace Infuso\Cms\Reflex\Behaviour;
use Infuso\Cms\Reflex;
use Infuso\Core;

/**
 * todo тотально рефакторить класс
 **/
class activeRecord extends Core\Behaviour {

    public function behaviourPriority() {
        return - 1000;
    }

    public function reflexLogSource() {
        return $this;
    }

    public function reflexGetLog() {
        $index = get_class($this).":".$this->id();
        return reflex_log::all()->eq("index",$index);
    }

    /**
     * Возвращает редактор элемента
     **/
    public final function editor() {

        $map = \infuso\core\file::get(Core\Mod::app()->varPath()."/reflex/editors.php")->inc();

        $class = $this->reflexEditor();

        if(!$class) {

            $classes = $map[get_class($this)];
            if(!$classes) {
                $classes = array();
            }

            $class = end($classes);

        }

        if(!$class) {
        	$editor = new Reflex\NoneEditor;
            return $editor;
        }

        return new $class($this->id());

    }

    public function reflexEditor() {
        return null;
    }

    /**
     * Метод должен вернуть Массив коллекций потомков
     * Переопределите его в своем классе для реализации иерархии
     **/
    public function reflexChildren() {
        return array();
    }

    public final function childrenWithBehaviours() {
        $ret = $this->reflex_children();
        $ret2 = $this->callBehaviours("reflex_children");
        return array_merge($ret,$ret2);
    }
    
    /**
     * Возвращает объект файлового хранилища, связанного с данным объектом
     **/
    public final function storage() {
        $source = $this->reflex_storageSource();
        return new \Infuso\Cms\Reflex\Storage(get_class($source),$source->id());
    }

    public function log($text,$params=array()) {

        if(!$this->editor()->log()) {
			return;
		}

        if(get_class($this)=="reflex_log") {
			return;
		}

		$source = $this->reflex_logSource();

        $log = reflex::create("reflex_log",array(
            "user" => \user::active()->id(),
            "index" => get_class($source).":".$source->id(),
            "text" => $text,
            "comment" => $params["comment"],
        ));
    }
    
    /**
     * Возвращает объект домена, связанного с элементом
     **/
    public final function domain() {
        $ret = $this->reflex_domain();
        if(!is_object($ret)) {
            $ret = reflex_domain::get($ret);
        }
        return $ret;
    }

    private $metaObject = null;

    /**
     * Возвращает объект метаданных данного объекта.
     * На практике рекомендуется пользоваться ф-цией reflex::meta()
    **/
    public final function metaObject($lang=null) {

        if(!$this->metaObject) {

            if(!$lang) {
                $lang = \lang::active()->id();
            }

            if(get_class($this)=="reflex_meta_item") {
                return $this;
            }

            if(!$this->reflex_meta()) {
                return mod::service("ar")->virtual("reflex_meta_item");
            }

            $this->metaObject = \reflex_meta_item::get(get_class($this).":".$this->id(),$lang);
        }

        return $this->metaObject;
    }

    /**
     * reflex::meta($key,$val)
     * При вызове с одним параметром вернет значение метаданных с этим ключем.
     * При вызове с двумя параметрами - изменит.
     **/
    public final function meta($key,$val=null) {

        if(func_num_args()==1) {

            $ret = $this->metaObject()->data($key);
            return $ret;

        } elseif (func_num_args()==2) {

            $obj = $this->metaObject();
            if(!$obj->exists()) {
                $hash = get_class($this).":".$this->id();
                $obj = reflex::create("reflex_meta_item",array(
					"hash" => $hash,
				));
				$this->metaObject = $obj;
            }
            $obj->data($key,$val);
        }
    }

    /**
     * Изменяет url-адрес объекта
     **/
    public function setUrl($url) {

        if(!$this->reflex_route()) {
            return;
        }

        $hash = get_class($this).":".$this->id();
        $route = reflex_route_item::get($hash);

        if(!$route->exists()) {
            $route = reflex::create("reflex_route_item",array(
				"hash" => $hash,
			));
        }

        $route->data("url",$url);

        // Сохраняем мету. Это вызовет исправление url (русский в транслит, проблемы в тире и т.п.)
        $route->store();
    }

    /**
     * @return bool
     * true - объект опубликован
     * false - не опубликован
     **/
    public function published() {
        return $this->reflexPublished();
    }
    
    public function reflexPublished() {
        return true;
    }


}
