<?

namespace infuso\ActiveRecord;
use \infuso\core\event;
use \infuso\core\mod;
use \reflex;
use \infuso\core\profiler;
use \Infuso\Core\Model;
use \Infuso\Core;

/**
 * @todo вернуть register_shutdown_function или аналог
 **/
class Record extends \Infuso\Core\Model\Model {

	const STATUS_NEW = 100;
	const STATUS_VIRTUAL = 0;
	const STATUS_CHANGED = 300;
	const STATUS_SAVED = 400;
	const STATUS_DELETED = 500;
	const STATUS_NON_EXISTENT = 600;

	/**
	 * первичный ключ элемента
	 **/
    protected $id = null;

	/**
	 * Статус записи
	 **/
	protected $recordStatus = 0;

    /**
     * Фабрика полей
     * Возвращает поле по его имени
     * @todo сделать кэширвоанеи работы
     **/
    public function fieldFactory($name) {
		$model = $this->reflex_table();
		$ret = null;
		foreach($model["fields"] as $fieldDescr) {
		    if($fieldDescr["name"] == $name) {
		        $ret = Model\Field::get($fieldDescr);
		    }
		}
		return $ret;
    }
    
    /**
     * Возвращает массив имен полей модели
     * @todo сделать кэширвоанеи работы
     **/
    public function fieldNames() {
        $names = array();
        $model = $this->reflex_table();
		foreach($model["fields"] as $fieldDescr) {
		    $names[] = $fieldDescr["name"];
		}
		return $names;
    }
    
    public function handleRecordDataChanged() {
		Core\Mod::service("ar")->registerChanges(get_class($this),$this->id());
    }
    
    // Триггеры
    public function reflex_beforeCreate() {
    }

    public function reflex_afterCreate() {
    }

    public function reflex_beforeStore() {
    }

    public function reflex_afterStore() {
    }

    public function reflex_beforeDelete() {
    }

    public function reflex_afterDelete() {}

    public function __sleep() {
        return array(
            "id",
        );
    }
    
    public final function prefixedTableName() {
        $ret = $this->reflex_table();
        if($ret=="@") {
            return "infuso_".get_class($this);
        }
        return "infuso_".$ret["name"];
    }
    
	public final function tableExists() {
	    return true;
    }
    
    /**
     * @return Функция вызывается при создании коллекции
     * @param $items class reflex_list
     **/
    public function reflex_beforeCollection($items) {
        $this->callBehaviours("reflex_beforeCollection",$items);
    }

    public function defaultBehaviours() {
        $ret = parent::defaultBehaviours();
        $ret[] = "reflex_defaultBehaviour";
        $ret[] = "reflex_reflexBehaviour";
        return $ret;
    }

    public static function classes() {
        $ret = array();
        foreach(mod::service("classmap")->classes("infuso\\ActiveRecord\\Record") as $class) {
            if($class!="reflex_none") {
                $ret[] = $class;
            }
        }
        return $ret;
    }



    /**
     * Возвращает название объекта.
     * По умолчанию название, это значение поле title, или строка вида class:id,
     * если поле title пустое или не существует.
     * Заголовок объекта отображается в редакторе каталога
     * Саму функцию вы не можете переопределить, т.к. она финальная. Нужно переопределить ф-цию reflex_title()
     **/
    public final function title() {
        return $this->reflex_title();
    }

    /**
     * Возвращает url объекта.
     * URL может быть задан явно ф-цией reflex_url()
     * В противном случае URL будет сгенерирован автоматически для экшна classname/item/id/$id
     * Вы можете передать первым аргументом функции массив с параметрами, которые будут учтены при генерации URL
     **/
    public final function url($params = array()) {

        if(!is_array($params)) {
            $params = array();
        }

        if($url = trim($this->reflex_url())) {

            // Если адрес передается в формате action::class_name/action/p1/123/p2/456..., преобразуем адрес в url
            if(preg_match("/action::/",$url)) {
                $url = strtr($url,array("action::"=>""));
                $action = mod_action::fromString($url);
                return mod::url($action->url());
            // В противном случае возвращаем адрес как есть
            } else {
                return mod::url($url);
            }

        } else {

            $params["id"] = $this->id();
            $action = \mod_action::get(get_class($this),"item",$params);
            return mod::url($action->url());

        }

    }

    public final function __construct($id=0) {
        $this->id = $id;
    }

    public static function get($class,$id=null) {
    
        if(func_num_args()==1) {
            return Core\Mod::service("ar")->collection($class);
        } elseif(func_num_args()==2) {
            return Core\Mod::service("ar")->get($class,$id);
        }
        
        throw new \Exception("ActiveRecord::get() wrong number of arguments");

    }

    /**
     * @return true/false Существует ли объект
     **/
    public final function exists() {
        return !!$this->id;
    }

    /**
     * @return true/false в зависимости от того виртуальный ли объект
     **/
    public function isVirtual() {
        return $this->recordStatus() == self::STATUS_VIRTUAL;
    }
    
    public function setRecordStatus($status) {
        $this->recordStatus = $status;
    }
    
	public function recordStatus() {
	    return $this->recordStatus;
    }

    /**
     * Нормализует имя столбца, защищая от инъекций
     * Возможные варианты:
     * field
     * table.field
     * fn(field)
     **/
    public static function normalizeColName($name,$table=null) {

        $symbols = "[a-z0-9\_\-\:]+";

        if(preg_match("/^{$symbols}$/i",$name)) {
            return "`$table`.`".$name."`";
        }

        if(preg_match("/^({$symbols})\.({$symbols})$/i",$name,$matches)) {
            return "`".$matches[1]."`.`".$matches[2]."`";
        }

        // Функции
        if(preg_match("/^([a-z0-9\_]+)\(({$symbols})\)$/i",$name,$matches)) {
            return $matches[1]."(`$table`.`".$matches[2]."`)";
        }

        // Функции
        if(preg_match("/^([a-z0-9\_]+)\(({$symbols})\.({$symbols})\)$/i",$name,$matches)) {
            return $matches[1]."(`".$matches[2]."`.`".$matches[3]."`)";
        }

        return "";
    }

    /**
     * Запускает триггер
     * Выполняет метод $fn объекта и все методы $fn поведений, если такие есть.
     * Возвращает false, если хотя бы один из вызванных методов вернул false
     * Если false не был возвращен ни одним из методов, вернет true
     **/
    public final function callReflexTrigger($fn,$event) {

        if($this->$fn()===false) {
            return;
		}
            
        foreach($this->behaviours() as $b) {
            if(method_exists($b,$fn)) {
                if($b->$fn($event)===false) {
                    return false;
				}
			}
		}

        if(in_array($fn,array(
            "reflex_beforeCreate",
            "reflex_beforeStore",
            "reflex_beforeDelete",
        ))) {
            if(!$this->callReflexTrigger("reflex_beforeOperation",$event)) {
                return false;
			}
		}

        if(in_array($fn,array(
            "reflex_afterCreate",
            "reflex_afterStore",
            "reflex_afterDelete",
        ))) {
            $this->callReflexTrigger("reflex_afterOperation",$event);
		}
		
		$event->fire();
		
        return true;
    }

    /**
     * Удаляет объект
     * Очищает хранилище объекта
     **/
    public final function delete() {

        if(!$this->exists())
            return;
            
		$event = new event("reflex_beforeDelete",array(
		    "item" => $this,
		));

        // Вызываем пре-триггеры
        if(!$this->callReflexTrigger("reflex_beforeDelete",$event)) {
            return;
		}

        $prefixedTableName = $this->table()->prefixedName();
        $id = reflex_mysql::escape($this->id());
        reflex_mysql::query("delete `$tableName` from `$prefixedTableName` as `$tableName` where `id`='$id'");

        // Очищаем хранилище (Если не используется чужое хранилище)
        if($this->storage()->reflex()==$this) {
        	$this->storage()->clear();
        }
        
		$event = new event("reflex_afterDelete",array(
		    "item" => $this,
		));

        // Вызываем пост-триггеры
        if(!$this->callReflexTrigger("reflex_afterDelete",$event)) {
            return;
		}

        // Счетчик
        self::$deleted++;
    }

    /**
     * Добавляет новую запись в базу
     **/
    public static function create($class, $data = array(), $keepID = false) {
		return mod::service("ar")->create($class,$data,$keepID);
    }

    /**
     * Создает для данного объекта запись в базе
     **/
    public function createThis($keepID = false) {

		/*$event = new \Infuso\Core\Event("reflex_beforeCreate",array(
		    "item" => $this,
		));

        if(!$this->callReflexTrigger("reflex_beforeCreate",$event)) {
            return false;
        } */

		$this->storeCreated($keepID);
            
		/*$event = new \Infuso\Core\Event("reflex_afterCreate",array(
		    "item" => $this,
		));
        
        $this->callReflexTrigger("reflex_afterCreate",$event);
        */

    }

    /**
     * Сохраняет созданный объект в базу
     **/
    private final function storeCreated($keepID = false) {
    
        if(!$this->writeEnabled()) {
            return false;
		}

		$event = new event("reflex_beforeStore",array(
		    "item" => $this,
		));

        if(!$this->callReflexTrigger("reflex_beforeStore",$event)) {
            return false;
		}
		
        $table = $this->prefixedTableName();

        // Вставляем в таблицу
        $data = array();
        foreach($this->fields() as $field) {
            if($field->name()!="id" || $keepID) {
                $data[$this->normalizeColName($field->name(),$table)] = $field->mysqlValue();
            }
        }
        $insert = " (".implode(",",array_keys($data)).") values (".implode(",",$data).") ";

        $query = "insert into `$table` $insert ";
        $id = mod::service("db")->query($query)->exec()->lastInsertId();

        // Заносим данные в объект
        // Объект заносим объект в буфер
        $this->field("id")->initialValue($id);

        $this->id = $id;

        $this->reflex_updateSearch();
        
		$event = new event("reflex_afterStore",array(
		    "item" => $this,
		));
		
		$this->callReflexTrigger("reflex_afterStore",$event);

        return true;
    }

    /**
     * Сохраняет виртуальный объект в базу
     * Если объект не виртуальный, просто сохраняет его
     * Метод отличается от reflex::store, который игнорирует виртуальные объекты
     **/
    public function storeVirtual() {

        if($this->isVirtual()) {
            $this->isVirtual = false;
            $this->createThis();
        } else {
            $this->store();
        }

    }

    /**
     * Возвращает первичный ключ объекта
     **/
    public final function id() {
        return $this->id;
    }

    /**
     * Сохраняет в базу все изменения
     **/
    public static function storeAll() {
		mod::service("ar")->storeAll();
    }

    private final function from() {
        return "`".$this->prefixedTableName()."`";
    }

    private final function writeEnabled() {
    
        if($this->isVirtual()) {
            return false;
         }

        return true;
    }
    
    public function markAsClean() {
        $this->setInitialData($this->data());
    }

    /**
     * Сохраняет изменения в базу
     **/
    public final function store() {

        if(!$this->writeEnabled()) {
            $this->markAsClean();
            return false;
        }
        
        if(!$this->fields()->changed()->count()) {
            $this->markAsClean();
            return false;
        }
        
		$event = new event("reflex_beforeStore",array(
		    "item" => $this,
		));

        // Триггер
        if(!$this->callReflexTrigger("reflex_beforeStore",$event)) {
            $this->markAsClean();
            return false;
        }

        // После вызова reflex_beforeCreate() поля объекта могуть стать такими же как в были до изменений
        // В этом случае нет смысла сохранять объект в базу
        $changedFields = $this->fields()->changed();
        if(!$changedFields->count()) {
            $this->markAsClean();
            return true;
        }

        $set = array();
        foreach($changedFields as $field) {
            $set[] = "`".$field->name()."`=".$field->mysqlValue();
        }
        $set = "set ".implode(",",$set)." ";

        $id = $this->id();

        $from = $this->from();
        mod::service("db")->query("update $from $set where `id`='$id' ")->exec();

        // Сразу после сохранения, помечаем объект как чистый
        // Таким образом, если в reflex_afterStore() будут изменены поля объекта,
        // Метод store может быть вызванповторно
        $this->markAsClean();
        
		$event = new event("reflex_afterStore",array(
		    "item" => $this,
		    "changedFields" => $changedFields,
		));

        $this->callReflexTrigger("reflex_afterStore",$event);

        return true;
    }

    /**
     * Возвращает объект в исходное состояние
     * Отменяя все изменения, сделанные после загрузки
     **/
    public function revert() {
        foreach($this->fields() as $field) {
            $field->revert();
        }
        $this->markAsClean();
    }

    /**
     * Записывает объект и удаляет его из буфера
     **/
    public final function free() {
        $this->store();
        $this->markAsClean();
    }

    /**
     * Записывает все объекты и очищает буффер
     **/
    public static function freeAll() {
        mod::service("ar")->freeAll();
    }

    /**
     * Возвращает цепочку родителей
     * @return Array
     **/
    public final function parents() {
        $parents = array();
        $parent = $this;
        $n=0;
        while(1) {
            $parent = $parent->reflex_parent();
            if(!$parent)
                break;
            if(!$parent->exists())
                break;
            $parents[] = $parent;
            $n++;

            if($n>100)
                break;
        }
        return array_reverse($parents);
    }

    /**
     * Проверяет цепочку родителей на рекурсию
     * Проходит по родителям, и, если встретит одного из них дважды - возвращает true
     * @return Bool
     **/
    public final function testForParentsRecursion() {
        $parents = array($this);
        $parent = $this;
        while(1) {
            $parent = $parent->reflex_parent();
            if(!$parent) break;
            if(!$parent->exists()) break;
            if(in_array($parent,$parents)) return true;
            $parents[] = $parent;
        }
        return false;
    }

    /**
     * Возвращает родителя элемента
     **/
    public final function parent() {
        return $this->reflex_parent();
    }


    

}
