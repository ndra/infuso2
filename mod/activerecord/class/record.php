<?

namespace infuso\ActiveRecord;
use \infuso\core\event;
use \infuso\core\mod;
use \reflex;
use \infuso\core\pfofiler;
use \Infuso\Core\Model;
use \Infuso\Core;

/**
 * @todo вернуть register_shutdown_function или аналог
 **/
abstract class Record extends \Infuso\Core\Model\Model {

	/**
	 * Новая запись
	 **/
	const STATUS_NEW = 0;

	/**
	 * Запись не привязана к базе
	 **/
	const STATUS_DETACHED = 100;
	
	/**
	 * Запись изменена, изменения не сохранены
	 **/
	const STATUS_CHANGED = 300;
	
	/**
	 * Запись синхронизирвоана с базой
	 **/
	const STATUS_SYNC = 400;
	
	/**
	 * Запись удалена
	 **/
	const STATUS_DELETED = 500;
	
	/**
	 * Запись не существует
	 **/
	const STATUS_NON_EXISTENT = 600;

	/**
	 * первичный ключ элемента
	 **/
    protected $id = null;

	/**
	 * Статус записи
	 **/
	protected $recordStatus = 0;
    
    public static function prepareName($name) {
    
        if($name !== null) {
        
            $name = mb_strtolower($name);
            $name = strtr($name, array(
                "\\" => "_",
            ));
            
            $name = preg_replace("/_+/", "_", $name);
            
            if(!preg_match("/^[a-z0-9_]+$/", $name)) {
                throw new \Exception("Wrong table name `$name` ");
            }
        }
    
        return $name;
    }
    
    public static function modelExtended($scenario) {
        $ret = parent::modelExtended($scenario);
        $ret["name"] = self::prepareName($ret["name"]); 
        return $ret;
    }

    /**
     * При изменении данных модели, меняем ее статус и сообщаем службе ar об изменениях
	 **/
    public function handleModelDataChanged() {
    	if(in_array($this->recordStatus(), array(self::STATUS_SYNC, self::STATUS_CHANGED))) {
			service("ar")->registerChanges(get_class($this),$this->id());
			$this->setRecordStatus(self::STATUS_CHANGED);
		}
    }
    
	/**
	 * @return Функция должна вернуть url объекта
	 * По умолчанию, url объекта имеет вид /my_class_name/item/id/123
	 * Переопределите функцию, если у элемента должен быть другой url
	 **/
	public function _recordUrl() {
		return null;
	}

	/**
	 * @return Функция должна вернуть родительский элемент
	 * Это должен быть существующий или не существующий объект reflex, либо null
	 * Родитель используется в каталоге для построения пути к объекту
	 **/
	public function recordParent() {
		return service("ar")->get("reflex_none", 0);
	}
	
	public function recordTitle() {

        if(!$this->exists()) {
			return "";
		}

		if($field = $this->recordTitleField()) {
        	if($title = $this->data($field)){
	            return $title;
	        }
        }

        return get_class($this).":".$this->id();
    }

    public function recordTitleField() {
        // перебираем поля до первого поля с именем title
        foreach($this->fields() as $field) {
            if($field->name()=="title") {
                return $field->name();
            }
        }
        // перебираем поля до первого поля сторокогвого типа и возвращаем его имя
        foreach($this->fields() as $field){
            if($field->typeID() == "v324-89xr-24nk-0z30-r243"){
                return $field->name();
            }
        }

        return false;
    }
    
    /**
     * Триггер, вызывается перед созданием
     **/
    public function beforeCreate() {
    }

	/**
     * Триггер, вызывается после создания
     **/
    public function afterCreate() {
    }

	/**
     * Триггер, вызывается до сохранения
     **/
    public function beforeStore() {
    }

	/**
     * Триггер, вызывается после сохранения
     **/
    public function afterStore() {
    }

	/**
     * Триггер, вызывается перед удалением
     **/
    public function beforeDelete() {
    }

	/**
     * Триггер, вызывается после удаления
     **/
    public function afterDelete() {
	}
	
	/**
	 * Триггер, вызывающийся перед каждой поперацией создания, изменения или удаления
	 **/
	public function beforeOperation() {
	}

	/**
	 * Триггер, вызывающийся после каждой поперацией создания, изменения или удаления
	 **/
	public function afterOperation() {
	}

    /**
     * Этот метод очень важен
     * Он используется в шаблонах (не напрямую, но через serialize())
     * Для определения параметров кэшируемого шаблона его данные сериализируются
     * Если передать параметров ActiveRecord, то при сериализации он превратится в массив, который можно видеть ниже
     **/
    public function __sleep() {
        return array(
            "id",
        );
    }
    
    public final function prefixedTableName() {
        $ret = self::modelExtended("");
        return "infuso_".$ret["name"];
    }
    
	public final function tableExists() {
	    return true;
    }
    
    /**
     * @return Функция вызывается при создании коллекции
     **/
    public function beforeCollection($collection) {
		foreach($this->behaviourMethods("beforeCollection") as $method) {
		    $method($collection);
		}

    }

    public static function classes() {
        $ret = array();
        foreach(service("classmap")->classes("infuso\\ActiveRecord\\Record") as $class) {
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
     * Саму функцию вы не можете переопределить, т.к. она финальная. Нужно переопределить ф-цию recordTitle()
     **/
    public final function title() {
        return $this->recordTitle();
    }

    /**
     * Возвращает url объекта.
     * URL может быть задан явно ф-цией recordUrl()
     * В противном случае URL будет сгенерирован автоматически для экшна classname/item/id/$id
     * Вы можете передать первым аргументом функции массив с параметрами, которые будут учтены при генерации URL
     **/
    public final function url($params = array()) {

        if(!is_array($params)) {
            $params = array();
        }

        if($url = trim($this->recordUrl())) {

            // Если адрес передается в формате action::class_name/action/p1/123/p2/456..., преобразуем адрес в url
            if(preg_match("/action::/",$url)) {
                $url = strtr($url,array("action::"=>""));
                $action = \Infuso\Core\Action::fromString($url);
                if(!$action->isCorrect()) {
                    throw new \Exception("Incorrect action: $url");
                }
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

    public final function __construct($id = 0) {
        $this->id = $id;
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return true/false Существует ли объект
     **/
    public final function exists() {
        return !!$this->id;
    }

	/**
	 * Меняет статус записи
	 * вы не должны вызывать этот метод напрямую
	 **/
    public function setRecordStatus($status) {
        $this->recordStatus = $status;
    }
    
    /**
     * Возвращает статус записи
     **/
	public function recordStatus() {
	    return $this->recordStatus;
    }

    /**
     * Нормализует имя столбца, защищая от инъекций
     * Возможные варианты:
     * field
     * table.field
     * fn(field)
     * @todo - я добавил возвожность использовать бэкслэши в именах полей. Проверить на возможность инъекций
     **/
    public static function normalizeColName($name, $table = null) {

        $symbols = "[a-z0-9\_\-\:\\\\]+";

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

        throw new \Exception("normalizeColName - bad field name \"$name\"");
    }

    /**
     * Запускает триггер
     * Выполняет метод $fn объекта и все методы $fn поведений, если такие есть.
     * Возвращает false, если хотя бы один из вызванных методов вернул false
     * Если false не был возвращен ни одним из методов, вернет true
     **/
    public final function callReflexTrigger($event) {
    
        $fn = preg_replace("/^activerecord\//i", "", $event->name());
        $fn = strtolower($fn);

        if($this->$fn() === false) {
            return;
		}
            
        foreach($this->behaviourMethods($fn) as $closure) {
            if($closure($event) === false) {
                return false;
			}
        }
        
        $event->fire();

        if(in_array($fn, array(
            "beforecreate",
            "beforestore",
            "beforedelete",
        ))) {
        
            $event = new Core\Event("ActiveRecord/BeforeOperation", array(
                "item" => $this,
            ));
            if(!$this->callReflexTrigger($event)) {
                return false;
			}
		}

        if(in_array($fn, array(
            "aftercreate",
            "afterstore",
            "afterdelete",
        ))) {
            $event = new Core\Event("ActiveRecord/AfterOperation", array(
                "item" => $this,
            ));
            if(!$this->callReflexTrigger($event)) {
                return false;
			}
		}
		
        return true;
    }

    /**
     * Удаляет объект
     * Очищает хранилище объекта
     **/
    public final function delete() {

        if(!$this->exists())
            return;
            
		$event = new event("ActiveRecord/beforeDelete", array(
		    "item" => $this,
		));

        // Вызываем пре-триггеры
        if(!$this->callReflexTrigger($event)) {
            return;
		}

        $prefixedTableName = $this->prefixedTableName();
        $id = service("db")->quote($this->id());
        service("db")->query("delete `$tableName` from `$prefixedTableName` as `$tableName` where `id`={$id}")->exec();

        // Очищаем хранилище (Если не используется чужое хранилище)
        if($this->storage()->record() == $this) {
        	$this->storage()->clear();
        }
        
		$event = new event("ActiveRecord/AfterDelete", array(
		    "item" => $this,
		));

        // Вызываем пост-триггеры
        if(!$this->callReflexTrigger($event)) {
            return;
		}

    }

    /**
     * Создает для данного объекта запись в базе
     * @todo вернуть триггеры
     **/
    public function createThis($keepID = false) {

		$event = new \Infuso\Core\Event("ActiveRecord/BeforeCreate", array(
		    "item" => $this,
		));

        if(!$this->callReflexTrigger($event)) {
            return false;
        }

		$this->storeCreated($keepID);     
		
        // Объект заносим объект в буфер
        service("ar")->storeToBuffer($this);
        
        // Меняем статус объекта
        $this->setRecordStatus(self::STATUS_SYNC);
            
		$event = new \Infuso\Core\Event("ActiveRecord/AfterCreate",array(
		    "item" => $this,
		));
        
        $this->callReflexTrigger($event);

    }

    /**
     * Сохраняет созданный объект в базу
     * @todo сделать сохранение объектов в буффер
     **/
    private final function storeCreated() {
    
		$event = new event("ActiveRecord/BeforeStore",array(
		    "item" => $this,
		));

        if(!$this->callReflexTrigger($event)) {
            return false;
		}
		
        $table = $this->prefixedTableName();

        // Вставляем в таблицу
        $data = array();
        foreach($this->fields() as $field) {
            $data[$this->normalizeColName($field->name(),$table)] = $field->mysqlValue();
        }
        $insert = " (".implode(",",array_keys($data)).") values (".implode(",",$data).") ";
        $query = "insert into `$table` $insert ";
        $id = service("db")->query($query)->exec()->lastInsertId();
        
        // Заносим id в данные объекта
        $initialData = $this->data();
        $initialData["id"] = $id;
        $this->setInitialData($initialData);
        $this->id = $id;

		$event = new event("ActiveRecord/AfterStore", array (
		    "item" => $this,
		));
		
		$this->callReflexTrigger($event);

        return true;
    }

    /**
     * Возвращает первичный ключ объекта
     **/
    public final function id() {
        return $this->id;
    }

	/**
	 * @todo Надобность в этой функции под вопросом
	 **/
    private final function from() {
        return "`".$this->prefixedTableName()."`";
    }

	/**
	 * Помечает объект как сохраненный:
	 * Очищает список измененных полей модели (они становятся начальными значениями)
	 * Меняет статус записи на «Синхронизировано»
	 * Удаляет объект из списка измененных в службе "ar"
	 **/
    public function markAsUnchanged() {
        $this->setInitialData($this->data());
        $this->setRecordStatus(self::STATUS_SYNC);
        service("ar")->unregisterChanges(get_class($this),$this->id());
    }

    /**
     * Сохраняет изменения в базу
     **/
    public final function store() {
    
    	// Сохраняем измененные объекты
		if(in_array($this->recordStatus(), array(self::STATUS_CHANGED))) {

	        if(!$this->fields()->changed()->count()) {
	            $this->markAsUnchanged();
	            return false;
	        }
	        
			$event = new event("ActiveRecord/BeforeStore",array(
			    "item" => $this,
			));
	
	        // Триггер
	        if(!$this->callReflexTrigger($event)) {
	            $this->markAsUnchanged();
	            return false;
	        }
	
	        // После вызова beforeCreate() поля объекта могуть стать такими же как в были до изменений
	        // В этом случае нет смысла сохранять объект в базу
	        $changedFields = $this->fields()->changed();
	        if(!$changedFields->count()) {
	            $this->markAsUnchanged();
	            return true;
	        }
	
			// Подготавливаем запрос в базу
	        $set = array();
	        foreach($changedFields as $field) {
	            $set[] = "`".$field->name()."`=".$field->mysqlValue();
	        }
	        $set = "set ".implode(",",$set)." ";
	        $id = $this->id();
	        $from = $this->from();
	        service("db")->query("update $from $set where `id`='$id' ")->exec();
	
	        // Сразу после сохранения, помечаем объект как чистый
	        // Таким образом, если в afterStore() будут изменены поля объекта,
	        // Метод store может быть вызван повторно
	        $this->markAsUnchanged();
	        
			$event = new event("ActiveRecord/AfterStore",array(
			    "item" => $this,
			    "changedFields" => $changedFields,
			));
	
	        $this->callReflexTrigger($event);
	
	        return true;
        }
    }

    /**
     * Возвращает объект в исходное состояние
     * Отменяя все изменения, сделанные после загрузки
     * @todo $fields
     **/
    public function revert() {
        foreach($this->fields() as $field) {
            $field->revert();
        }
        $this->markAsUnchanged();
    }

    /**
     * Возвращает родителя элемента
     **/
    public final function parent() {
        return $this->recordParent();
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
            $parent = $parent->recordParent();
            if(!$parent) {
                break;
            }
            if(!$parent->exists()) {
                break;
            }
            $parents[] = $parent;
            $n++;

            if($n>100) {
                break;
            }
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
            $parent = $parent->recordParent();
            if(!$parent) {
				break;
			}
            if(!$parent->exists()) {
				break;
			}
            if(in_array($parent,$parents)) {
				return true;
			}
            $parents[] = $parent;
        }
        return false;
    }
    
    public function storage() {
        $storage = new Storage(get_class($this),$this->id());
		return $storage;
    }
    
    public function recordStorageFolder() {
        return null;
    }


}
